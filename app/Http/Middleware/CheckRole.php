<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $status = false;

        if(Auth::check()){
            switch($role) {
                case 'admin':
                    if (Auth::user()->isAdmin()) {
                        $status = true;
                    }
                    break;
                case 'shipper':
                    if (Auth::user()->isShipper()) {
                        $status = true;
                    }
                    break;
                case 'packageOwner':
                    if (Auth::user()->isPackageOwner()) {
                        $status = true;
                    }
                    break;
            }
        }

        if ($status) {
            return $next($request);
        } else {
            return response()->json(['error' => "Unauthorized", 'code' => 401], 401);
        }

    }
}
