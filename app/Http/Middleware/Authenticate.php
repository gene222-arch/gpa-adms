<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * * Get the path the user should be redirected to when they are not authenticated.
     * ? Is there any better way to refactor this code taking advantage of laravel spatie/permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson())
        {
            if (! Auth::check()) // Not authenticated
            {
                if (Route::is('admin.*') && Auth::guard('admin'))
                {
                    return ('/admin/login');
                }

                if (Auth::guard('web'))
                {
                    return ('/login');
                }
            }
            else // Authenticated
            {
                if (Route::is('admin.*'))
                {
                    if (
                        Auth::guard('web') &&
                        ! Auth::user()->hasRole('super_admin')
                        )
                    {
                        return abort(403);
                    }
                }
            }
        }
    }



}
