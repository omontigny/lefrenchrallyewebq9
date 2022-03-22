<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_Rallye extends Model
{
    //
    public $table = "admin_rallye";
    public function rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users');
    }
}
