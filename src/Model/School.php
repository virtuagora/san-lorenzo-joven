<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public $timestamps = false;
    protected $table = 'schools';
    protected $visible = [
        'id', 'name', 'neighbourhoods'
    ];

    public function neighbourhoods()
    {
        return $this->hasMany('App\Model\Neighbourhood');
    }
}
