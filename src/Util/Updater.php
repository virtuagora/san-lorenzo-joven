<?php

namespace App\Util;

class Updater
{
    protected $db;
    protected $schema;
    
    public function __construct($db)
    {
        $this->db = $db;
        $this->schema = $db->schema();
    }

    public function up()
    {


        // $this->db->schema()->create('project_benefited_districts', function ($table) {
        //     $table->engine = 'InnoDB';
        //     $table->increments('id');
        //     $table->integer('project_id')->unsigned();
        //     $table->integer('district_id')->unsigned();
        //     $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        //     $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        // });

        // $this->schema->table('projects', function($t) {
        //     $t->string('authors')->nullable();
        // });
        
        // $this->schema->table('citizens', function($t) {
        //     $t->dropColumn('voted_at');
        //     $t->boolean('voted')->default(false);
        // });

        // $this->schema->dropIfExists('online_ballots');
        // $this->schema->dropIfExists('online_votes');
        
        // $this->schema->create('online_ballots', function ($t) {
        //     $t->engine = 'InnoDB';
        //     $t->increments('id');
        //     $t->string('code', 10)->nullable();
        //     $t->timestamp('created_at');
        //     $t->boolean('sent')->nullable(); // false -> invalid
        // });

        // $this->schema->table('online_ballots', function($t) {
        //     $t->integer('count')->unsigned();
        // });

        // $this->schema->create('online_votes', function ($t) {
        //     $t->engine = 'InnoDB';
        //     $t->increments('id');
        //     $t->string('hash');
        //     $t->integer('project_id')->unsigned();
        //     $t->foreign('project_id')->references('id')->on('projects');
        // });

        // $this->schema->create('statistical_ballots', function ($t) {
        //     $t->engine = 'InnoDB';
        //     $t->increments('id');
        //     $t->string('type'); // user, link, tablet, paper
        //     $t->string('gender')->nullable;
        //     $t->integer('age')->nullable();
        //     $t->timestamps();
        // });
        // $this->schema->create('audit_trails', function ($t) {
        //     $t->engine = 'InnoDB';
        //     $t->increments('id');
        //     $t->string('file_name');
        //     $t->string('state');
        //     $t->string('description');
        //     $t->text('extra')->nullable();
        //     $t->timestamps();
        // });

        // 2025-05-01 Added to optios table "allow-signup" and "no-signup-message"
        $alreadyExists = $this->db->table('options')->where('key', 'allow-signup')->first();
        if(!$alreadyExists){
            $this->db->table('options')->insert([
                'key' => 'allow-signup',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'varios',
                'autoload' => true,
            ]);
        }
        
        $alreadyExists = $this->db->table('options')->where('key', 'no-signup-message')->first();
        if(!$alreadyExists){
            $this->db->table('options')->insert([
                'key' => 'no-signup-message',
                'value' => 'Este año, no es necesario registrarse para subir el proyecto. Participá en las convocatorias presenciales para presentar tu proyecto o contactate con el equipo de Presupuesto Participativo Joven del Municipio de San Lorenzo.',
                'type' => 'string',
                'group' => 'varios',
                'autoload' => true,
            ]);
        }

    }
}
