<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parent_Event extends Model
{
    //
    public $table = "parent_event";

    public function parent()
    {
        return $this->belongsTo(\App\Models\Parents::class);
    }

    public function group()
    {
        return $this->belongsTo('App\Models\group');
    }
}
