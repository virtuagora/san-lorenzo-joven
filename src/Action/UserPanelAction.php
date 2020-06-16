<?php

namespace App\Action;

use App\Util\Exception\UnauthorizedException;
use App\Util\Exception\AppException;
use Carbon\Carbon;

class UserPanelAction
{
    protected $userResource;
    protected $options;
    protected $representation;
    protected $helper;
    protected $authorization;
    protected $db;
    protected $filesystem;
    protected $pagination;
    protected $view;

    public function __construct(
        $userResource, $options, $representation, $helper, $authorization, $db, $filesystem, $pagination, $view
    ) {
        $this->userResource = $userResource;
        $this->options = $options;
        $this->representation = $representation;
        $this->helper = $helper;
        $this->authorization = $authorization;
        $this->db = $db;
        $this->filesystem = $filesystem;
        $this->pagination = $pagination;
        $this->view = $view;
    }

    //
    public function showOverview($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        if (!$this->authorization->checkPermission($subject, 'user')) {
            throw new UnauthorizedException();
        }
        $user = $this->helper->getUserFromSubject($subject);
        return $this->view->render($response, 'sl/panel/overview.twig', [
            'user' => $user
        ]);
    }
    public function showChangePassword($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        if (!$this->authorization->checkPermission($subject, 'user')) {
            throw new UnauthorizedException();
        }
        return $this->view->render($response, 'sl/panel/change-pass.twig', []);
    }

    public function showProjects($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        if (!$this->authorization->checkPermission($subject, 'user')) {
            throw new UnauthorizedException();
        }
        $user = $this->helper->getUserFromSubject($subject);
        $projects = $this->db->query('App:Project', ['district'])
            ->where('author_id', $user->id)->get()->toArray();
        return $this->view->render($response, 'sl/panel/projects.twig', [
            'proyectos' => $projects,
            'user' => $user
        ]);
    }

    public function showVerify($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        if (!$this->authorization->checkPermission($subject, 'user')) {
            throw new UnauthorizedException();
        }
        $user = $this->helper->getUserFromSubject($subject);
        $user->makeVisible(['verified_dni']);
        // $projects = $this->db->query('App:Project', ['district'])
            // ->where('author_id', $user->id)->get()->toArray();
        return $this->view->render($response, 'sl/panel/verify.twig', [
            'user' => $user,
        ]);
    }

    public function runUploadDniUser($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        $user = $this->helper->getUserFromSubject($subject);
        // $user = $this->helper->getEntityFromId(
        //     'App:User', 'usr', $params
        // );
        if (!$this->authorization->checkPermission($subject, 'updUsrDni', $user)) {
            throw new UnauthorizedException();
        }
        $atributos = $request->getParsedBody();
        if (empty($request->getUploadedFiles()['archivo'])) {
            throw new AppException('No se envió un archivo');
        }
        $archivo = $request->getUploadedFiles()['archivo'];
        $this->userResource->updateDni($subject, $user, $atributos, $archivo);
        return $response->withRedirect($request->getHeaderLine('HTTP_REFERER'));
    }

    public function getDniFile($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        $usuario = $this->helper->getEntityFromId(
            'App:User', 'usr', $params
        );
        if (!$this->authorization->checkPermission($subject, 'admin', $usuario) 
        && !$this->authorization->checkPermission($subject, 'updUsrDni', $usuario)) {
            throw new UnauthorizedException();
        }
        $fileData = $this->userResource->getDniFile($usuario);
        return $response->withBody(new \Slim\Http\Stream($fileData['strm']))
            ->withHeader('Content-Type', $fileData['mime']);
    }

    public function showCreateProject($request, $response, $params)
    {
        $available = $this->options->getOption('proposals-available')->value;
        $appState = $this->options->getOption('current-state')->value == 'upload-proposals';
        if (!$available || !$appState) {
            throw new AppException('El formulario no se encuentra disponible');
        }
        $launch = $this->options->getOption('proposals-launch')->value;
        $deadline = $this->options->getOption('proposals-deadline')->value;
        $today = Carbon::now();
        if (!$today->between($launch, $deadline)) {
            throw new AppException('El plazo de presentación y edición de proyectos ha vencido.');
        }
        $subject = $request->getAttribute('subject');
        // if (!$this->authorization->checkPermission($subject, 'verified')) {
        if (!$this->authorization->checkPermission($subject, 'user')) {
            throw new UnauthorizedException();
        }
        $user = $this->helper->getUserFromSubject($subject);
        $user->addVisible(['email','dni']);
        return $this->view->render($response, 'sl/panel/create-project.twig', [
            'user' => $user,
        ]);
    }
    public function showEditProject($request, $response, $params)
    {
        $available = $this->options->getOption('proposals-available')->value;
        $appState = $this->options->getOption('current-state')->value == 'upload-proposals';
        if (!$available || !$appState) {
            throw new AppException('El formulario no se encuentra disponible');
        }
        $launch = $this->options->getOption('proposals-launch')->value;
        $deadline = $this->options->getOption('proposals-deadline')->value;
        $today = Carbon::now();
        if (!$today->between($launch, $deadline)) {
            throw new AppException('El plazo de presentación y edición de proyectos ha vencido.');
        }
        $subject = $request->getAttribute('subject');
        $project = $this->helper->getEntityFromId(
            'App:Project', 'pro', $params
        );
        if (!$this->authorization->checkPermission($subject, 'updateProject', $project)) {
            throw new UnauthorizedException();
        }
        $user = $this->helper->getUserFromSubject($subject);
        $project->addVisible(['notes', 'author_phone', 'author_email', 'author_dni']);
        return $this->view->render($response, 'sl/panel/edit-project.twig', [
            'proyecto' => $project->toArray(),
            'user' => $user
        ]);
    }

    public function showProjectImage($request, $response, $params)
    {
        $available = $this->options->getOption('proposals-available')->value;
        $appState = $this->options->getOption('current-state')->value == 'upload-proposals';
        if (!$available || !$appState) {
            throw new AppException('El formulario no se encuentra disponible');
        }
        $launch = $this->options->getOption('proposals-launch')->value;
        $deadline = $this->options->getOption('proposals-deadline')->value;
        $today = Carbon::now();
        if (!$today->between($launch, $deadline)) {
            throw new AppException('El plazo de presentación y edición de proyectos ha vencido.');
        }
        $subject = $request->getAttribute('subject');
        $project = $this->helper->getEntityFromId(
            'App:Project', 'pro', $params
        );
         if (!$this->authorization->checkPermission($subject, 'updateProject', $project)) {
            throw new UnauthorizedException();
        }
        return $this->view->render($response, 'sl/panel/edit-project-image.twig', [
            'proyecto' => $project->toArray(),
        ]);
    }
    
    // TODO
    public function showProjectFiles($request, $response, $params)
    {
        $available = $this->options->getOption('proposals-available')->value;
        $appState = $this->options->getOption('current-state')->value == 'upload-proposals';
        if (!$available || !$appState) {
            throw new AppException('El formulario no se encuentra disponible');
        }
        $launch = $this->options->getOption('proposals-launch')->value;
        $deadline = $this->options->getOption('proposals-deadline')->value;
        $today = Carbon::now();
        if (!$today->between($launch, $deadline)) {
            throw new AppException('El plazo de presentación y edición de proyectos ha vencido.');
        }
        $subject = $request->getAttribute('subject');
        $project = $this->helper->getEntityFromId(
            'App:Project', 'pro', $params, ['documents']
        );
         if (!$this->authorization->checkPermission($subject, 'updateProject', $project)) {
            throw new UnauthorizedException();
        }
        $project->addVisible(['documents']);
        return $this->view->render($response, 'sl/panel/edit-project-files.twig', [
            'proyecto' => $project->toArray(),
        ]);
    }

    public function showProjectJournal($request, $response, $params)
    {
        $subject = $request->getAttribute('subject');
        $project = $this->helper->getEntityFromId(
            'App:Project', 'pro', $params, ['author']
        );
         if (!$this->authorization->checkPermission($subject, 'updateProject', $project)) {
            throw new UnauthorizedException();
        }
        $userArr = array();
        foreach ($project->journal as $key => $value) {
            $user = $this->helper->getEntityFromId(
            'App:User', $value['author_id'], null, ['subject']
            );
            $userArr[$value['author_id']] = $user->subject->toDummy()->toArray();
        }
        $project->addVisible(['notes', 'author_phone', 'author_email', 'author_dni','author','journal']);
        return $this->view->render($response, 'sl/panel/edit-project-journal.twig', [
            'proyecto' => $project->toArray(),
            'users' => $userArr
        ]);
    }
}