<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    //
    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }
    public function parent_groups()
    {
        return $this->hasMany(\App\Models\Parent_Group::class);
    }

    public function parent_rallyes()
    {
        return $this->hasMany(\App\Models\Parent_Rallye::class);
    }

    public function parent_events()
    {
        return $this->hasMany(\App\Models\Parent_Event::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }

    public function children()
    {
        return $this->hasMany(\App\Models\Children::class);
    }
}
