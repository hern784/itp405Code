<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Configuration::select('value')->first()->value) {
            if (Auth::check()) {
                if (Auth::user()->isAdmin()) {
                    return $next($request);
                }
            }
            return redirect()->route('configuration.maintenance');
        }
        return $next($request);
    }
}
