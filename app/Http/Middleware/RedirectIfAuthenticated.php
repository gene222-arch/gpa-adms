<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * * Redirect the authenticated users
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard)
        {
            if (Auth::check())
            {
                /**
                 * Admins Route
                 */
                if ($guard === 'admin')
                {
                    if (Auth::user()->hasRole('super_admin'))
                    {
                        return redirect()->route('admin.dashboard');
                    }
                }

                /**
                 * Non - admins routes
                 */
                if ($guard === 'web')
                {
                    if (Auth::user()->hasRole('recipient'))
                    {
                        return redirect()->route('recipient.dashboard');
                    }

                    if (Auth::user()->hasRole('volunteer'))
                    {
                        return redirect()->route('volunteer.dashboard');
                    }
                }

                // Check for accessing admin routes
                if (Route::is('admin.*'))
                {
                    if (
                        Auth::guard('admin')->check() &&
                        Auth::user()->hasRole('super_admin'))
                    {
                        // Continue request if auth is super-admin & guard is admin
                        return $next($request);
                    }
                    if (Auth::guard('web')->check())
                    {
                        // Redirect to Unauthorized web page, status code 403
                        return abort(403);
                    }
                }
            }
        }

        return $next($request);
    }

}
