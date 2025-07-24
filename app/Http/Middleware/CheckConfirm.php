<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckConfirm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Cache::has('sold_data')) {
            if (Cache::has('esim_data')) {
                return redirect()->route('sale.index');
            } else {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
