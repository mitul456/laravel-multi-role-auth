<?php

namespace Mitul456\LaravelMultiRoleAuth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mitul456\LaravelMultiRoleAuth\Models\Role;
use Mitul456\LaravelMultiRoleAuth\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin|SuperAdmin');
    }

    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);
        return view('multirole::roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('multirole::roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles',
            'guard_name' => 'required|string',
            'description' => 'nullable|string',
            'priority' => 'integer',
            'permissions' => 'array'
        ]);

        $role = Role::create($validated);
        
        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('multirole::roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'priority' => 'integer',
            'permissions' => 'array'
        ]);

        $role->update($validated);
        
        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}