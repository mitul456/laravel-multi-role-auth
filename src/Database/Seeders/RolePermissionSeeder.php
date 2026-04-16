<?php

namespace Mitul456\LaravelMultiRoleAuth\Database\Seeders;

use Illuminate\Database\Seeder;
use Mitul456\LaravelMultiRoleAuth\Models\Role;
use Mitul456\LaravelMultiRoleAuth\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view-dashboard', 'manage-users', 'manage-roles', 'manage-permissions',
            'create-posts', 'edit-posts', 'delete-posts', 'publish-posts',
            'manage-comments', 'moderate-content', 'view-reports', 'manage-settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
                'description' => "Can {$permission}"
            ]);
        }

        // Create roles with priorities (higher priority = more power)
        $roles = [
            'SuperAdmin' => ['priority' => 100, 'description' => 'Full system access'],
            'Admin' => ['priority' => 80, 'description' => 'Administrative access'],
            'Moderator' => ['priority' => 60, 'description' => 'Content moderation'],
            'Editor' => ['priority' => 40, 'description' => 'Content creation and editing'],
            'User' => ['priority' => 20, 'description' => 'Regular user access'],
        ];

        foreach ($roles as $name => $data) {
            Role::create([
                'name' => $name,
                'guard_name' => 'web',
                'priority' => $data['priority'],
                'description' => $data['description']
            ]);
        }

        // Assign permissions to roles
        $superAdmin = Role::where('name', 'SuperAdmin')->first();
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::where('name', 'Admin')->first();
        $admin->syncPermissions([
            'view-dashboard', 'manage-users', 'manage-roles', 'manage-permissions',
            'view-reports', 'manage-settings'
        ]);

        $moderator = Role::where('name', 'Moderator')->first();
        $moderator->syncPermissions([
            'view-dashboard', 'manage-comments', 'moderate-content', 'view-reports'
        ]);

        $editor = Role::where('name', 'Editor')->first();
        $editor->syncPermissions([
            'view-dashboard', 'create-posts', 'edit-posts', 'publish-posts'
        ]);

        $user = Role::where('name', 'User')->first();
        $user->syncPermissions([
            'view-dashboard'
        ]);
    }
}