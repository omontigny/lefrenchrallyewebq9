<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schoolyear extends Model
{
    // Table Name

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }
    
}
