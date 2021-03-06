<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecipientController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    * GET Requests
    |--------------------------------------------------------------------------
    */

    public function showReceivedReliefAsstLists(Request $request)
    {
        if ($request->wantsJson())
        {
            return response()->json($request->user()->reliefGoodsByRecipients, 200);
        }

        return view('users.recipients.received-relief-asst-lists');
    }

}
