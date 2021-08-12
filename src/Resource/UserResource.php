<?php

namespace App\Resource;

use App\Util\Exception\AppException;
use App\Util\Paginator;
use Carbon\Carbon;

class UserResource extends Resource
{
    public function retrieveSchema($options = [])
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'names' => [
                    'type' => 'string',
                    'minLength' => 1,
                    'maxLength' => 75,
                ],
                'surnames' => [
                    'type' => 'string',
                    'minLength' => 1,
                    'maxLength' => 75,
                ],
                'password' => [
                    'type' => 'string',
                    'minLength' => 4,
                    'maxLength' => 250,
                ],
                'dni' => [
                    'type' => 'string',
                    'minLength' => 7,
                    'maxLength' => 9,
                ],
                'email' => [
                    'type' => 'string',
                    'format' => 'email',
                ],
                'birthday' => [
                    'type' => 'string',
                    'pattern' => '^\d{4}-\d{2}-\d{2}$',
                ],
                'neighbourhood_id' => [
                    'type' => 'integer',
                    'minimum' => 1,
                ],
                'token' => [
                    'type' => 'string',
                    'minLength' => 10,
                    'maxLength' => 100,
                ],
                'bio' => [
                    'oneOf' => [
                        [
                            'type' => 'string',
                            'maxLength' => 1500,
                        ], [
                            'type' => 'null',
                        ],
                    ],
                ],
            ],
            'required' => ['names', 'surnames', 'password', 'birthday', 'neighbourhood_id', 'dni', 'token'],
            'additionalProperties' => false,
        ];
        return $schema;
    }

    public function retrieve($options)
    {
        $query = $this->db->query('App:User');
        if (isset($options['dni_state'])) {
            if ($options['dni_state'] == 2) {
                $query->whereNotNull('dni')->where(function ($qry) {
                    $qry->whereNull('verified_dni')
                        ->orWhere('verified_dni', false);
                });
            } elseif ($options['dni_state'] == 3) {
                $query->where('verified_dni', true);
            }
        }
        if (isset($options['roles'])) {
            $roles = explode(',', $options['roles']);
            $query->whereHas('subject.roles', function ($qry) use ($roles) {
                $qry->whereIn('role_id', $roles);
            });
        }
        if (isset($options['s'])) {
            $filter = $this->helper->generateTrace($options['s']);
            $query->where('trace', 'LIKE', "%$filter%");
        }
        $results = new Paginator($query, $options);
        return $results;
    }

    public function retrieveAdmins($options)
    {
        $query = $this->db->query('App:User')
            ->whereHas('subject.roles', function ($qry) {
                $qry->whereIn('role_id', ['admin']);
            });
        if (isset($options['email'])) {
            $filter = $this->helper->generateTrace($options['email']);
            $query->where('email', 'LIKE', "%$filter%");
        }
        $results = $query->take(10)->get();
        $results->makeVisible('email');
        return $results;
    }

    public function retrievePendingUsers()
    {
        $results = $this->db->query('App:PendingUser')->get();
        $results->makeVisible('created_at');
        $results->makeVisible('updated_at');
        return $results;
    }

    public function retrievePendingVoters()
    {
        $results = $this->db->table('users')
            ->join('subjects', 'users.subject_id', '=', 'subjects.id')
            ->join('citizens', 'subjects.citizen_id', '=', 'citizens.id')
            ->whereNotNull('subjects.citizen_id')
            ->where('citizens.voted', false)
            ->select(
            'users.id',
            'users.names',
            'users.surnames',
            'users.email',
            'users.created_at',
            'users.updated_at',
            'citizens.table',
            'citizens.orden',
            'citizens.year',
            'citizens.data',
            'citizens.genre'
            )
            ->get();
        return $results;
    }

    public function retrieveCandidatos($options)
    {
        $query = $this->db->query('App:User')
            ->whereHas('subject.roles', function ($qry) {
                $qry->whereIn('role_id', ['user']);
            })
            ->whereDoesntHave('subject.roles', function ($qry) use ($excluded) {
                $qry->whereIn('role_id', ['admin']);
            });
        if (isset($options['email'])) {
            $filter = $this->helper->generateTrace($options['email']);
            $query->where('email', 'LIKE', "%$filter%");
        }
        $results = $query->take(10)->get();
        $results->makeVisible('email');
        return $results;
    }

    public function createOne($subject, $data)
    {
        $v = $this->validation->fromSchema($this->retrieveSchema());
        $v->assert($data);
        $token = $data['token'];
        unset($data['token']); //Why Matu?
        $user = $this->identity->registerUser($data, $token);
        return $user;
    }

    public function createPendingUser($subject, $data) // el subject sirve para invitaciones

    {
        $pending = $this->identity->createPendingUser('local', $data);
        // $mailMsg = 'Accede con ' . $pending->token;

        $mailSub = 'Verificá tu registro';
        $link = $this->helper->pathFor('showCompleteSignUp', true, [], [
            'token' => $pending->token,
        ]);
        $mailMsg = $this->view->fetch('emails/completeRegister.twig', [
            'url' => $link,
        ]);

        $this->logger->info($link);
        $this->mailer->sendMail($mailSub, $pending->identifier, $mailMsg, 'text/html');
    }


    public function resendPending($subject, $data) // el subject sirve para invitaciones

    {
        $pending = $this->db->query('App:PendingUser')
                    ->where('id',$data['id'])->firstOrFail();
        $pending->touch();
        // $mailMsg = 'Accede con ' . $pending->token;

        $mailSub = '¡Completá tu registro y votá!';
        $link = $this->helper->pathFor('showCompleteSignUp', true, [], [
            'token' => $pending->token,
        ]);
        $mailMsg = $this->view->fetch('emails/resendCompleteRegister.twig', [
            'url' => $link,
        ]);

        $this->logger->info('Resend: ' . $link);
        $this->mailer->sendMail($mailSub, $pending->identifier, $mailMsg, 'text/html');
    }

    public function sendPendingVoter($subject, $data) // el subject sirve para invitaciones

    {
        $user = $this->db->query('App:User')
                    ->where('id',$data['id'])->firstOrFail();
        $user->touch();
        // $mailMsg = 'Accede con ' . $pending->token;

        $mailSub = '¡No te olvides de votar!';
        $link = $this->helper->pathFor('showCatalogo', true, [], []);
        $mailMsg = $this->view->fetch('emails/sendPendingVote.twig', [
            'url' => $link,
        ]);

        $this->logger->info('Invite: ' . $link);
        $this->mailer->sendMail($mailSub, $user->email, $mailMsg, 'text/html');
    }

    public function sendVerifiedUserByAdmin($subject, $data) // el subject sirve para invitaciones

    {
        $user = $this->db->query('App:User')
                    ->where('id',$data['id'])->firstOrFail();
        $user->touch();
        // $mailMsg = 'Accede con ' . $pending->token;

        $mailSub = '¡Ya podes comenzar a votar en PP Joven!';
        $link = $this->helper->pathFor('showCatalogo', true, [], []);
        $mailMsg = $this->view->fetch('emails/verifiedUserByAdmin.twig', [
            'url' => $link,
        ]);

        $this->logger->info('Verified By Admin: ' . $link);
        $this->mailer->sendMail($mailSub, $user->email, $mailMsg, 'text/html');
    }

    // public function updateProfile($subject, $user, $data)
    // {
    //     $schema = [
    //         'type' => 'object',
    //         'properties' => [
    //             'birthday' => [
    //                 'type' => 'string',
    //                 'pattern' => '^\d{4}-\d{2}-\d{2}$',
    //             ],
    //             'gender' => [
    //                 'type' => 'string',
    //                 'enum' => ['Hombre', 'Mujer', 'HombreTrans', 'MujerTrans', 'Intersex'],
    //             ],
    //             'address' => [
    //                 'type' => 'string',
    //                 'minLength' => 1,
    //                 'maxLength' => 300,
    //             ],
    //             'telephone' => [
    //                 'type' => 'string',
    //                 'minLength' => 1,
    //                 'maxLength' => 20,
    //             ],
    //             'locality_id' => [
    //                 'type' => 'integer',
    //                 'minimum' => 1,
    //             ],
    //             'locality_other' => [
    //                 'oneOf' => [
    //                     [
    //                         'type' => 'string',
    //                         'minLength' => 1,
    //                         'maxLength' => 250,
    //                     ], [
    //                         'type' => 'null',
    //                     ],
    //                 ],
    //             ],
    //             'neighbourhood' => [
    //                 'type' => 'string',
    //                 'minLength' => 1,
    //                 'maxLength' => 100,
    //             ],
    //             'referer' => [
    //                 'oneOf' => [
    //                     [
    //                         'type' => 'string',
    //                         'minLength' => 1,
    //                         'maxLength' => 250,
    //                     ], [
    //                         'type' => 'null',
    //                     ],
    //                 ],
    //             ],
    //             'referer_other' => [
    //                 'oneOf' => [
    //                     [
    //                         'type' => 'string',
    //                         'minLength' => 1,
    //                         'maxLength' => 250,
    //                     ], [
    //                         'type' => 'null',
    //                     ],
    //                 ],
    //             ],
    //         ],
    //         'required' => [
    //             'birthday', 'gender', 'address', 'telephone', 'neighbourhood',
    //             'locality_id', 'locality_other', 'referer', 'referer_other'
    //         ],
    //         'additionalProperties' => false,
    //     ];
    //     $v = $this->validation->fromSchema($schema);
    //     $v->assert($data);
    //     $localidad = $this->db->query('App:Locality')->findOrFail($data['locality_id']);
    //     $user->birthday = $data['birthday'];
    //     $user->gender = $data['gender'];
    //     $user->address = $data['address'];
    //     $user->telephone = $data['telephone'];
    //     $user->neighbourhood = $data['neighbourhood'];
    //     $user->referer = $data['referer'];
    //     $user->referer_other = $data['referer_other'];
    //     $user->locality_id = $data['locality_id'];
    //     $user->locality_other = $localidad->custom ? $data['locality_other'] : null;
    //     $user->save();
    //     return $user;
    // }

    public function updatePublicProfile($subject, $user, $data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'bio' => [
                    'oneOf' => [
                        [
                            'type' => 'string',
                            'minLength' => 1,
                            'maxLength' => 300,
                        ], [
                            'type' => 'null',
                        ],
                    ],
                ],
            ],
            'required' => [
                'bio',
            ],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        $user->bio = $data['bio'];
        $user->save();
        return $user;
    }

    public function updateRoles($subject, $data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'user_email' => [
                    'type' => 'string',
                    'format' => 'email',
                ],
                'role' => [
                    'type' => 'string',
                    'enum' => ['user', 'admin', 'coordin'],
                ],
            ],
            'required' => [
                'role', 'user_email',
            ],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($this->validation->prepareData($schema['properties'], $data));
        $user = $this->db->query('App:User')
            ->where('email', $data['user_email'])
            ->firstOrFail();
        // $roles = array_merge(['user'], [$data['role']]);
        $user->subject->roles()->syncWithoutDetaching($data['role']);
        return true;
    }

    public function updatePendingEmail($subject, $user, $data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'format' => 'email',
                    'minLength' => 1,
                    'maxLength' => 300,
                ],
            ],
            'required' => [
                'email',
            ],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        $user->pending_email = $data['email'];
        $user->token = 'email:' . bin2hex(random_bytes(10));
        $user->token_expiration = Carbon::tomorrow();
        $user->save();
        $mailSub = 'Cambio de email en Ingenia';
        $link = $this->helper->pathFor('runUpdUserEma', true, [
            'usr' => $user->id,
            'tkn' => $user->token,
        ]);
        $mailMsg = $this->view->fetch('emails/updateEmail.twig', [
            'url' => $link,
        ]);
        $this->mailer->sendMail($mailSub, $data['email'], $mailMsg, 'text/html');
    }

    public function updateEmail($user, $data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'pattern' => '^email:[A-z0-9]+$',
                    'minLength' => 1,
                    'maxLength' => 50,
                ],
            ],
            'required' => [
                'token',
            ],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        if ($user->token != $data['token']) {
            throw new AppException('Token inválido');
        }
        if ($user->token_expiration->lt(Carbon::now())) {
            throw new AppException('Token expirado');
        }
        $other = $this->db->query('App:User')->where('email', $user->pending_email)->first();
        if (isset($other)) {
            throw new AppException('Esa dirección de email ya está registrada');
        }
        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->token = null;
        $user->token_expiration = null;
        $user->save();
    }

    public function resetPassword($data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'email' => [
                    'type' => 'string',
                    'format' => 'email',
                ],
            ],
            'required' => ['email'],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        $user = $this->db->query('App:User')
            ->where('email', $data['email'])
            ->firstOrFail();
        $user->token = 'password:' . bin2hex(random_bytes(10));
        $user->token_expiration = Carbon::tomorrow();
        $user->save();
        $mailSub = 'Cambio de contraseña';
        $link = $this->helper->pathFor('showCompletePasswordRestore', true, [
            'usr' => $user->id,
            'tkn' => $user->token,
        ]);
        $mailMsg = $this->view->fetch('emails/resetPassword.twig', [
            'url' => $link,
        ]);
        $this->mailer->sendMail($mailSub, $data['email'], $mailMsg, 'text/html');
    }

    public function restorePassword($user, $data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'pattern' => '^password:[A-z0-9]+$',
                    'minLength' => 1,
                    'maxLength' => 50,
                ],
                'password' => [
                    'type' => 'string',
                    'minLength' => 3,
                    'maxLength' => 250,
                ],
                'repeat' => [
                    'type' => 'string',
                    'minLength' => 3,
                    'maxLength' => 250,
                ],
            ],
            'required' => ['token', 'password', 'repeat'],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        if ($user->token != $data['token']) {
            throw new AppException('Token inválido');
        }
        if ($user->token_expiration->lt(Carbon::now())) {
            throw new AppException('Token expirado');
        }
        if ($data['password'] !== $data['repeat']) {
            throw new AppException(
                'Clave nueva no coincide con su campo de control'
            );
        }
        $user->password = $data['password'];
        $user->token = null;
        $user->token_expiration = null;
        $user->save();
    }

    public function updatePassword($user, $data)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'current' => [
                    'type' => 'string',
                    'minLength' => 3,
                    'maxLength' => 250,
                ],
                'new' => [
                    'type' => 'string',
                    'minLength' => 3,
                    'maxLength' => 250,
                ],
                'repeat' => [
                    'type' => 'string',
                    'minLength' => 3,
                    'maxLength' => 250,
                ],
            ],
            'required' => ['current', 'new', 'repear'],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        if ($data['new'] !== $data['repeat']) {
            throw new AppException(
                'Clave nueva no coincide con su campo de control'
            );
        } elseif (!password_verify($data['current'], $user->password)) {
            throw new AppException(
                'Clave incorrecta'
            );
        }
        $user->password = $data['new'];
        $user->save();
    }

    public function updateDni($subject, $user, $data, $file)
    {
        $schema = [
            'type' => 'object',
            'properties' => [
                'gender' => [
                    'type' => 'string',
                    'minLength' => 1,
                    'maxLength' => 1,
                ],
                'notes' => [
                    'type' => 'string',
                    'maxLength' => 2000,
                ],
            ],
            'required' => [],
            'additionalProperties' => false,
        ];
        $v = $this->validation->fromSchema($schema);
        $v->assert($data);
        if ($user->verified_dni) {
            throw new AppException('No puede actualizar su DNI una vez verificado');
        }
        if ($file->getError() === UPLOAD_ERR_INI_SIZE || $file->getError() === UPLOAD_ERR_FORM_SIZE) {
            throw new AppException('El archivo excede el límite de tamaño permitido');
        } elseif ($file->getError() !== UPLOAD_ERR_OK) {
            throw new AppException('Hubo un error con el archivo recibido. Código ' . $file->getError());
        }
        $fileMime = $file->getClientMediaType();
        $allowedMimes = [
            'application/pdf' => 'pdf',
            'invalid/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'image/jpeg' => 'jpg',
            'image/pjpeg' => 'jpg',
            'image/png' => 'png',
        ];
        if (!isset($allowedMimes[$fileMime])) {
            throw new AppException('Tipo de documento inválido');
        }
        // $dniBlacklist = $this->options->getOption('dni-blacklist');
        $fileStrm = $file->getStream()->detach();
        $fileName = $user->id . '.' . $allowedMimes[$fileMime];
        $this->filesystem->putStream('dni/' . $fileName, $fileStrm);
        if (is_resource($fileStrm)) {
            fclose($fileStrm);
        }
        $user->verified_dni = false;
        $user->gender = $data['gender'];
        $user->notes = $data['notes'];
        $user->dni_file = $fileName;
        $user->save();
    }

    public function getDniFile($user)
    {
        // if ($this->filesystem->has('dni/' . $user->id . '.pdf')) {
        //     $path = 'dni/' . $user->id . '.pdf';
        // } elseif ($this->filesystem->has('dni/' . $user->id . '.jpg')) {
        //     $path = 'dni/' . $user->id . '.jpg';
        // } elseif ($this->filesystem->has('dni/' . $user->id . '.png')) {
        //     $path = 'dni/' . $user->id . '.png';
        // } elseif ($this->filesystem->has('dni/' . $user->id . '.doc')) {
        //     $path = 'dni/' . $user->id . '.doc';
        // } elseif ($this->filesystem->has('dni/' . $user->id . '.docx')) {
        //     $path = 'dni/' . $user->id . '.docx';
        // } else {
        //     throw new AppException(
        //         'El documento no se encuentra almacenado',
        //         404
        //     );
        // }
        $path = 'dni/'. $user->dni_file;
        if (!$this->filesystem->has($path)) {
            throw new AppException(
                'El documento no se encuentra almacenado',
                404
            );
        }
        $mime = $this->filesystem->getMimetype($path);
        $strm = $this->filesystem->readStream($path);
        return [
            'strm' => $strm,
            'mime' => $mime,
        ];
    }
}
