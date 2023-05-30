<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesMarketingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && auth()->user()->role_name == 'sales and marketing'){
            return $next($request);
         }
         else {           
            return response()
                    ->json(['status' => false,'status_code'=> 401, 'message' => 'Unauthenticated'], 401);
         }
    }
}
