<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    //
    public function rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function invitation()
    {
        return $this->belongsTo('App\Models\invitation');
    }

    // public function group()
    // {
    //     return $this->belongsTo('App\Models\Group');
    // }

    public function parent_events()
    {
        return $this->hasMany(\App\Models\Parent_Event::class);
    }

    public function checkins()
    {
        return $this->hasMany(\App\Models\CheckIn::class);
    }
}
