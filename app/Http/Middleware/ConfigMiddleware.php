<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ConfiguraController;
use Closure;
use Illuminate\Http\Request;

class ConfigMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $configController = resolve(ConfiguraController::class);
        $myConfig = $configController->rafael();

        // Compartilhe a variável globalmente para todas as views
        view()->share('myConfig', $myConfig);

        return $next($request);
    }
}
