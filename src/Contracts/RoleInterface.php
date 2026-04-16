<?php

namespace Mitul456\LaravelMultiRoleAuth\Contracts;

interface RoleInterface
{
    public function users();
    public function permissions();
    public function givePermissionTo($permission);
    public function revokePermissionTo($permission);
    public function syncPermissions(array $permissions);
    public function hasPermission($permission): bool;
}