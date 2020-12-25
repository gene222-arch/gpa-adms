<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConstituentsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('users.constituent.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    ! GET Requests
    |--------------------------------------------------------------------------
    */

    public function showReceivedReliefAsstLists(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json(auth()->user()->ro, 200);
        }

        return view('users.constituent.received-relief-asst-lists');
    }

}
