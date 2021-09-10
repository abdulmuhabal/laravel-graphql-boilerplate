<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        //    echo "NULL USER"; exit;
            return response("You cant access this page" , 401);
            // return "NULL";
        }

        $actions = $request->route()->getAction();
        $roles = isset($actions['role']) ? $actions['role'] : null ;
        foreach ($roles as $key => $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }
        
        return response("You cant access this page" , 401);
        // return "no ROLE";
        // echo "NO ROLE USER"; exit;

    }
}
