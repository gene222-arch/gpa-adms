<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLinkRequestForm()
    {
        return view('auth.admin.passwords.email');
    }

    protected function broker()
    {
        // get the info from the config/auth file
        // This identifies what model/table to save the data
        return Password::broker('admins');
    }

    protected function guard()
    {
        // helps us know how to logged us in
        return Auth::guard('admin');
    }
}
