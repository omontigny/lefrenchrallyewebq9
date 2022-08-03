<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
  //
  public function group()
  {
    return $this->belongsTo(\App\Models\Group::class);
  }

  public function rallye()
  {
    return $this->belongsTo(\App\Models\Rallye::class);
  }

  public function checkins()
  {
    return $this->hasMany(\App\Models\CheckIn::class);
  }

  public function user()
  {
    return $this->belongsTo(\App\User::class);
  }
}
