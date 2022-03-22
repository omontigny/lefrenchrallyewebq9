<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    public $table="children";
    public function rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }

    public function application()
    {
        return $this->belongsTo(\App\Models\Application::class);
    }

    public function parents()
    {
        return $this->belongsTo(\App\Models\Parents::class);
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }

    public function checkins()
    {
        return $this->hasMany(\App\Models\CheckIn::class);
    }

}
