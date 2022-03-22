<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rallye extends Model
{
  // Table Name
  protected $fillable = ['title', 'isPetitRallye', 'rallyemail', 'user_id'];

  public function invitations()
  {
    return $this->hasMany(\App\Models\Invitation::class);
  }

  public function coordinator_rallyes()
  {
    return $this->hasMany(\App\Models\Coordinator_Rallye::class);
  }

  public function admin_Rallye()
  {
    return $this->hasMany(\App\Models\Admin_Rallye::class);
  }

  public function parent_rallyes()
  {
    return $this->hasMany(\App\Models\Parent_Rallye::class);
  }

  public function checkins()
  {
    return $this->hasMany(\App\Models\CheckIn::class);
  }

  public function payment()
  {
    return $this->hasMany(\App\Models\Payment::class);
  }

  public function user()
  {
    return $this->belongsTo(\App\User::class);
  }
}
