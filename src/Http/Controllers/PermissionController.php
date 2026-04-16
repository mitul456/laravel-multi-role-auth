<?php

namespace Mitul456\LaravelMultiRoleAuth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mitul456\LaravelMultiRoleAuth\Models\Permission;
use Mitul456\LaravelMultiRoleAuth\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(15);
        return view('multirole::permissions.index', compact('permissions'));
    }

    public function assign(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array|required'
        ]);

        $role->syncPermissions($request->permissions);
        
        return back()->with('success', 'Permissions assigned successfully');
    }
}