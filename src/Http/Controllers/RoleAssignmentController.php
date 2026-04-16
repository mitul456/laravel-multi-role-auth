<?php

namespace Mitul456\LaravelMultiRoleAuth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mitul456\LaravelMultiRoleAuth\Models\Role;

class RoleAssignmentController extends Controller
{
    public function assign(Request $request, $userId)
    {
        $userModel = config('auth.providers.users.model');
        $user = $userModel::findOrFail($userId);
        
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->assignRole($request->role);
        
        return back()->with('success', 'Role assigned successfully');
    }

    public function remove(Request $request, $userId)
    {
        $userModel = config('auth.providers.users.model');
        $user = $userModel::findOrFail($userId);
        
        $user->removeRole($request->role);
        
        return back()->with('success', 'Role removed successfully');
    }
}