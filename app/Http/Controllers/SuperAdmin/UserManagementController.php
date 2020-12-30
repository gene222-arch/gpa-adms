<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role:super_admin', 'auth:admin']);
    }

    public function showUserWithRoles()
    {
        return view('admins.super-admin.user-magement.roles', [
            'roles' => Role::all(),
        ]);
    }

    public function showUserWithPermissions()
    {
        return view('admins.super-admin.user-magement.permissions', [
            'permissions' => Permission::all()->map->name
        ]);
    }
}
