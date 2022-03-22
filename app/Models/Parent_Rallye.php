<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parent_Rallye extends Model
{
  public $table = "parent_rallye";
  public function rallye()
  {
    return $this->belongsTo(\App\Models\Rallye::class);
  }

  public function parent()
  {
    return $this->belongsTo(\App\Models\Parents::class);
  }

  public function application()
  {
    return $this->belongsTo(\App\Models\Application::class);
  }
}
