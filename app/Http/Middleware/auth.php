<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   
        public function handle($request, Closure $next)
     {
    $recipeId = $request->route('recipe');

    if (auth()->check() && auth()->user()->recipes->contains($recipeId)) {
        return $next($request);
    }-

    abort(403, 'Unauthorized action.');
   }
    }
