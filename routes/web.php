<?php

use App\Events\ReceivedReliefAsstEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginCtrl;
use App\Http\Controllers\Auth\Admin\RegisterController as AdminRegisterCtrl;
use App\Http\Controllers\Auth\Admin\ForgotPasswordController as AdminForgotPasswordCtrl;
use App\Http\Controllers\Auth\Admin\ResetPasswordController as AdminResetPasswordCtrl;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardCtrl;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\UserReliefManagementController;
use App\Http\Controllers\User\VolunteerController;
use App\Http\Controllers\User\ConstituentsController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/event', function () {
    event(new ReceivedReliefAsstEvent('New Thanks bro'));
    echo 'Mail sent!';
});

Route::get('/listen', function () {
    return view('testBroadcast');
});



/*
|--------------------------------------------------------------------------
? Users: Authentication, Volunteers Controller, Constituents Controller
|--------------------------------------------------------------------------
 */

/**
 * ! Users Auth: Login, Register, ResetPassword Routes
 */
Auth::routes();

/**
 * ! ConstituentsController
 *
 * User
 * Roles: 'constituent'
 */

Route::get('/auth-user', function (Request $request) {

    if ($request->wantsJson())
    {
        return response()->json(Auth::user());
    }
});

Route::group([
    'prefix' => 'cons',
    'as' => 'constituent.',
    'middleware' => 'role:constituent'
], function ()
{
    Route::get('/dashboard', [ConstituentsController::class, 'dashboard'])->name('dashboard');

    Route::group([
        'prefix' => 'relief-asst'
    ], function ()
    {
        Route::get('/receive/{user?}', [ConstituentsController::class, 'showReceivedReliefAsstLists'])->name('relief-asst.receive');
    });

});


/**
 * ! VolunteersControllers
 *
 * User
 * Roles: 'volunteer'
 */
Route::group([
    'prefix' => 'vol',
    'as' => 'volunteer.',
    'middleware' => 'role:volunteer'
], function ()
{
    // Dashboard
    Route::get('/dashboard', [VolunteerController::class, 'dashboard'])->name('dashboard');

    Route::group([
            'prefix' => 'relief-assistance',
            'as' => 'relief.'
        ], function () {

        /**
         * * GET METHODS
         */

        // Fetch user role relief asst. lists
        Route::get('/', [VolunteerController::class, 'showReliefAsstLists'])->name('relief-asst-list');
        // Fetch user with constituent role name
        Route::get('/constituents-lists', [VolunteerController::class, 'showConstituentsLists']);


        /**
         * * POST METHODS
         */

        Route::post('/donate', [VolunteerController::class, 'store'])->name('relief-asst-store');


        /**
         * * PUT/PATCH METHODS
         */

        Route::put('/donate', [VolunteerController::class, 'update'])->name('relief-asst-update');


        /**
         * * DELETE METHODS
         */

        Route::delete('/', [VolunteerController::class, 'destroy'])->name('relief-asst-destroy');
    });
});



/*
|--------------------------------------------------------------------------
! Super Admin
|--------------------------------------------------------------------------
 */
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',], function () {
    /*
    |--------------------------------------------------------------------------
    ? Login, Register, Reset Password
    |--------------------------------------------------------------------------
    */

        /**
         * * Log in or out routes
         */
        Route::get('/login', [AdminLoginCtrl::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginCtrl::class, 'login'])->name('login');
        Route::post('/logout', [AdminLoginCtrl::class, 'logout'])->name('logout');

        /**
         * * Register routes
         */
        Route::get('register', [AdminRegisterCtrl::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AdminRegisterCtrl::class, 'register'])->name('register');

        /**
         * * Password reset routes
         */
        Route::get('/password/reset', [AdminForgotPasswordCtrl::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/email', [AdminForgotPasswordCtrl::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [AdminResetPasswordCtrl::class, 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [AdminResetPasswordCtrl::class, 'reset'])->name('password.update');

        /**
         * ? Dashboard
         */
        Route::get('/dashboard', [AdminDashboardCtrl::class, 'index'])
            ->name('dashboard');

        Route::group([
            'prefix' => 'dashboard',
            'as' => 'dashboard.'], function ()
        {
            /**
             * ? User Management
             *
             * * Permissions
             * * Roles
             */

            Route::get('/user-management/permissions',
                [UserManagementController::class, 'showUserWithPermissions'])
                ->name('user-management.permissions');

            Route::get('/user-management/roles',
                [UserManagementController::class, 'showUserWithRoles'])
                ->name('user-management.roles');

            /**
             * ? User Relief Assistance Management
             *
             * * Show users with relief assistances
             * * Approve a user's relief assistance
             * * Disaapprove a user's relief assistance
             */

            Route::get('/relief-assistance-mngmt/volunteers',
                [ UserReliefManagementController::class, 'showVolunteersWithReliefAsst' ])
                ->name('relief-assistance-mngmt.volunteers');

            Route::put('/relief-assistance-mngmt/volunteers/approve',
                [ UserReliefManagementController::class, 'approveReliefAsst' ]);

            Route::put('/relief-assistance-mngmt/volunteers/disapprove',
                [ UserReliefManagementController::class, 'disapproveReliefAsst' ]);

            Route::put('/relief-assistance-mngmt/volunteers/receive',
                [ UserReliefManagementController::class, 'reliefAsstHasReceived' ]);

            Route::put('/relief-assistance-mngmt/volunteers/relieve',
                [ UserReliefManagementController::class, 'relieveReceivedReliefAsst' ]);

            Route::delete('/relief-assistance-mngmt/volunteers',
                [ UserReliefManagementController::class, 'removeReliefAsst' ]);
        });
});

