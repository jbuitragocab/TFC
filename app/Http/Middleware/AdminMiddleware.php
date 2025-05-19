<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminMiddleware
{
   public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->admin) {
        return $next($request);
    }

    abort(403, 'No tienes privilegios para acceder a esta sección.');
}
    
}