<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  //
  protected $fillable = ['rallye_id', 'application_id'];

  public function rallye()
  {
    return $this->belongsTo(\App\Models\Rallye::class);
  }

  public function application()
  {
    return $this->belongsTo(\App\Models\Application::class);
  }
}
