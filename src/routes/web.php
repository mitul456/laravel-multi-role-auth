<?php

use Illuminate\Support\Facades\Route;
use Mitul456\LaravelMultiRoleAuth\Http\Controllers\RoleController;
use Mitul456\LaravelMultiRoleAuth\Http\Controllers\PermissionController;
use Mitul456\LaravelMultiRoleAuth\Http\Controllers\RoleAssignmentController;

Route::middleware(['web', 'auth'])->group(function () {
    // Role Management Routes
    Route::prefix('admin')->middleware('role:Admin|SuperAdmin')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::post('users/{user}/assign-role', [RoleAssignmentController::class, 'assign'])->name('user.assign.role');
        Route::post('users/{user}/remove-role', [RoleAssignmentController::class, 'remove'])->name('user.remove.role');
    });

    // Role-specific dashboards
    Route::middleware('role:SuperAdmin')->get('/superadmin/dashboard', function () {
        return view('multirole::dashboards.admin');
    })->name('superadmin.home');

    Route::middleware('role:Admin')->get('/admin/dashboard', function () {
        return view('multirole::dashboards.admin');
    })->name('admin.home');

    Route::middleware('role:Moderator')->get('/moderator/dashboard', function () {
        return view('multirole::dashboards.moderator');
    })->name('moderator.home');

    Route::middleware('role:Editor')->get('/editor/dashboard', function () {
        return view('multirole::dashboards.editor');
    })->name('editor.home');

    Route::middleware('role:User')->get('/user/dashboard', function () {
        return view('multirole::dashboards.user');
    })->name('user.home');
});

// Custom login redirect based on role
Route::post('/login', function () {
    $credentials = request()->only('email', 'password');
    
    if (auth()->attempt($credentials)) {
        $user = auth()->user();
        return redirect()->to($user->getRedirectPath());
    }
    
    return back()->withErrors(['email' => 'Invalid credentials']);
})->middleware('guest');