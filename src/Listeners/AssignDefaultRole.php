<?php

namespace Mitul456\LaravelMultiRoleAuth\Listeners;

use Mitul456\LaravelMultiRoleAuth\Events\UserRegistered;

class AssignDefaultRole
{
    public function handle(UserRegistered $event)
    {
        $defaultRole = config('multirole.default_role', 'User');
        $event->user->assignRole($defaultRole);
    }
}