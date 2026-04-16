<?php

namespace Mitul456\LaravelMultiRoleAuth\Commands;

use Illuminate\Console\Command;
use Mitul456\LaravelMultiRoleAuth\Models\Role;

class SyncRoleCommand extends Command
{
    protected $signature = 'role:sync {user} {roles*}';
    protected $description = 'Sync roles for a user';

    public function handle()
    {
        $userModel = config('auth.providers.users.model');
        $user = $userModel::find($this->argument('user'));
        
        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        $roles = $this->argument('roles');
        $user->syncRoles($roles);
        
        $this->info("Roles synced for user '{$user->email}' successfully!");
        return 0;
    }
}