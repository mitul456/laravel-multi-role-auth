<?php

namespace Mitul456\LaravelMultiRoleAuth\Commands;

use Illuminate\Console\Command;
use Mitul456\LaravelMultiRoleAuth\Models\Role;

class AssignRoleCommand extends Command
{
    protected $signature = 'role:assign {user} {role}';
    protected $description = 'Assign a role to a user';

    public function handle()
    {
        $userModel = config('auth.providers.users.model');
        $user = $userModel::find($this->argument('user'));
        
        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        $role = Role::where('name', $this->argument('role'))->first();
        
        if (!$role) {
            $this->error('Role not found!');
            return 1;
        }

        $user->assignRole($role);
        $this->info("Role '{$role->name}' assigned to user '{$user->email}' successfully!");
        return 0;
    }
}