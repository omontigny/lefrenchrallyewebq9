<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parent_Group extends Model
{
    //
    public $table = "parent_group";

    public function parent()
    {
        return $this->belongsTo(\App\Models\Parents::class);
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }
}
