<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator_Rallye extends Model
{
    public $table = "coordinator_rallye";
    public function rallye()
    {
        return $this->belongsTo(\App\Models\Rallye::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(\App\Models\Coordinator::class);
    }
}
