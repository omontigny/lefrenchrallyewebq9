<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
  /**
   * The names of the attributes that should not be trimmed.
   *
   * @var array
   */
  protected $except = [
    'password',
    'password_confirmation',
  ];

  static function middle_dots($crumb, $max = 50)
  {
    if (strlen($crumb) > $max)
      $crumb = substr_replace($crumb, '...', $max / 2, round(-$max / 2));
    return $crumb;
  }
}
