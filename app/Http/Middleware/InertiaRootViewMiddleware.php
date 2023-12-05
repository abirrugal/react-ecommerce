<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InertiaRootViewMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin/*')) {
            Inertia::setRootView('layouts.admin');
        } else {
            Inertia::setRootView('layouts.app');
        }

        return $next($request);
    }
}
