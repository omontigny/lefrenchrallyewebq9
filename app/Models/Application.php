<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
  // Table Name
  protected $guarded = [];

  public function rallye()
  {
    return $this->belongsTo(\App\Models\Rallye::class);
  }

  public function school()
  {
    return $this->belongsTo(\App\Models\School::class);
  }

  public function user()
  {
    return $this->belongsTo(\App\User::class);
  }

  public function schoolyear()
  {
    return $this->belongsTo(\App\Models\Schoolyear::class);
  }

  public function parent()
  {
    return $this->belongsTo(\App\Models\Parents::class);
  }

  public function event()
  {
    return $this->belongsTo(\App\Models\Group::class);
  }

  public function group()
  {
    return $this->belongsTo(\App\Models\Group::class);
  }

  public function parentrallye()
  {
    return $this->belongsTo(\App\Models\Parent_Rallye::class);
  }

  public function checkin()
  {
    return $this->belongsTo(\App\Models\CheckIn::class);
  }
}
