<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class VolunteerDashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.volunteer.dashboard');
    }
}
