<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    //
    public function rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }
    public function coordinator_rallyes()
    {
        return $this->hasMany(\App\Models\Coordinator_Rallye::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
