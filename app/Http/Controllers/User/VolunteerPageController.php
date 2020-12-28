<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VolunteerPageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('users.volunteer.dashboard');
    }

    public function onProcessCreateReliefAsstPage()
    {
        return view('users.volunteer.on-process-and-create-relief-asst');
    }

    public function approvedReliefAsstPage()
    {

    }

    public function doSomething()
    {
        // stuff
    }

    public function dispatchedReliefAsstPage()
    {

    }
}
