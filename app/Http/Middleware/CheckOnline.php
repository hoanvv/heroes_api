<?php

namespace App\Http\Middleware;

use App\Entities\Shipper;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOnline
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
        $shipper = Auth::user()->shipper()->first();
        if ($shipper->is_online == Shipper::ONLINE_SHIP) {
            return $next($request);
        } else {
            $message = array(
                'success' => false,
                'message' => "You are being offline. You cannot use this feature.",
                'code' => 403
            );
            return response()->json($message, 403);
        }

    }
}
