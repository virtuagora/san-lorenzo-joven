<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Neighbourhood extends Model
{
    public $timestamps = false;
    protected $table = 'neighbourhoods';
    protected $visible = [
        'id', 'name', 'district_id', 'district', "school_id", "school",
    ];

    public function district()
    {
        return $this->belongsTo('App\Model\District');
    }

    public function school()
    {
        return $this->belongsTo('App\Model\School');
    }
}
