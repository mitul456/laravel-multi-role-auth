<?php

namespace Mitul456\LaravelMultiRoleAuth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'multirole:install';
    protected $description = 'Install the multi-role authentication package';

    public function handle()
    {
        $this->info('Installing Laravel Multi-Role Auth Package...');

        $this->call('vendor:publish', [
            '--provider' => 'Mitul456\\LaravelMultiRoleAuth\\LaravelMultiRoleAuthServiceProvider',
            '--tag' => 'multirole-migrations'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Mitul456\\LaravelMultiRoleAuth\\LaravelMultiRoleAuthServiceProvider',
            '--tag' => 'multirole-seeds'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Mitul456\\LaravelMultiRoleAuth\\LaravelMultiRoleAuthServiceProvider',
            '--tag' => 'multirole-config'
        ]);

        $this->call('vendor:publish', [
            '--provider' => 'Mitul456\\LaravelMultiRoleAuth\\LaravelMultiRoleAuthServiceProvider',
            '--tag' => 'multirole-views'
        ]);

        $this->call('migrate');

        if ($this->confirm('Do you want to seed default roles and permissions?')) {
            Artisan::call('db:seed', [
                '--class' => 'Mitul456\\LaravelMultiRoleAuth\\Database\\Seeders\\RolePermissionSeeder'
            ]);
            $this->info('Default roles and permissions seeded successfully!');
        }

        $this->info('Installation completed successfully!');
        $this->info('Add the HasRoles trait to your User model:');
        $this->line('use Mitul456\\LaravelMultiRoleAuth\\Traits\\HasRoles;');
        $this->line('');
        $this->info('Then run: composer dump-autoload');
    }
}