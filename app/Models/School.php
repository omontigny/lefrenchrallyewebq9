<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  // Table Name
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  // protected $fillable = [
  //   'name', 'state', 'added_by', 'user_id', 'approved'
  // ];
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(\App\User::class);
  }

  public function applications()
  {
    return $this->hasMany(\App\Models\Application::class);
  }
}
