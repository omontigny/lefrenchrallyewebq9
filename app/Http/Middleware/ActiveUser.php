<?php

namespace App\Http\Middleware;

use Closure;

class ActiveUser
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (auth()->user()->blocked_at) {
      $user = auth()->user();
      auth()->logout();
      return redirect()->route('login')
        ->withError('Your account is inactive since ' . $user->blocked_at . '. It will be reactivatd after membership confirmation');
    }

    return $next($request);
  }
}
