<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    protected $table = 'districts';
    protected $visible = [
        'id', 'name', 'neighbourhoods'
    ];

    public function neighbourhoods()
    {
        return $this->hasMany('App\Model\Neighbourhood');
    }

    public function projects() {
        return $this->belongsToMany('App\Model\Project', 'project_benefited_districts', 'district_id', 'project_id');
    }
}
