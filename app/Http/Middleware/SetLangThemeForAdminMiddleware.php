<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Enums\ThemeMode;
use Symfony\Component\HttpFoundation\Response;

class SetLangThemeForAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->type === 'admin' && $user->active) {
            app()->setLocale($user->lang);
        }
        if (auth()->user()?->theme) {
            view()->share('forcedTheme', $user->theme);
        } 

        return $next($request);
    }
}
