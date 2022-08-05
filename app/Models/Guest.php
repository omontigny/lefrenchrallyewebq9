<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
  //
  public function rallye()
  {
    return $this->belongsTo(\App\Models\Rallye::class);
  }
  public function Children()
  {
    return $this->belongsTo(\App\Models\Children::class);
  }
}
