<?php

namespace Mitul456\LaravelMultiRoleAuth\Commands;

use Illuminate\Console\Command;
use Mitul456\LaravelMultiRoleAuth\Models\Role;

class CreateRoleCommand extends Command
{
    protected $signature = 'role:create {name} {guard?} {--description=}';
    protected $description = 'Create a new role';

    public function handle()
    {
        $name = $this->argument('name');
        $guard = $this->argument('guard') ?? 'web';
        
        if (Role::where('name', $name)->exists()) {
            $this->error("Role '{$name}' already exists!");
            return 1;
        }

        $role = Role::create([
            'name' => $name,
            'guard_name' => $guard,
            'description' => $this->option('description')
        ]);

        $this->info("Role '{$name}' created successfully with ID: {$role->id}");
        return 0;
    }
}