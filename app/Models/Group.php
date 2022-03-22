<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // Table Name
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }

    public function calendar()
    {
        return $this->belongsTo(\App\Models\Calendar::class);
    }

    public function parent_groups()
    {
        return $this->hasMany(\App\Models\Parent_Group::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

    public function children()
    {
        return $this->hasMany(\App\Models\Children::class);
    }

    public function parent_events()
    {
        return $this->hasMany(\App\Models\Parent_Event::class);
    }

    public function checkins()
    {
        return $this->hasMany(\App\Models\CheckIn::class);
    }

    public function Invitation()
    {
        return $this->belongsTo(\App\Models\Invitation::class);
    }
}
