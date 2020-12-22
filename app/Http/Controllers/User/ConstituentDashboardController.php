<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ConstituentDashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.constituent.dashboard');
    }
}
