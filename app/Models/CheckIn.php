<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    //
    public $table="checkins";

    public function Children()
    {
        return $this->belongsTo(\App\Models\Children::class);
    }

    public function Calendar()
    {
        return $this->belongsTo(\App\Models\Calendar::class);
    }

    public function Invitation()
    {
        return $this->belongsTo(\App\Models\Invitation::class);
    }

    public function Rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }

    public function Group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }
}
