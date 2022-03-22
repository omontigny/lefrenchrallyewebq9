<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPrice extends Model
{
    //
    public $table="membershipprices";

    public function schoolyear()
    {
        return $this->belongsTo(\App\Models\Schoolyear::class);
    }
}
