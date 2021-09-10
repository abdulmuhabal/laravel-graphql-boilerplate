<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
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
       if ( $request->user() === null ) {
            return response("You cant access this page" , 401);
        }

        $actions = $request->route()->getAction();
        $role = isset($actions['role']) ? $actions['role'] : null ;
        if ($request->user()->hasRole($role)) {
            return $next($request);
        }

        return response("You cant access this page" , 401);
    }
}
