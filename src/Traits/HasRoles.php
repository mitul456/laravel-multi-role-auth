<?php

namespace Mitul456\LaravelMultiRoleAuth\Traits;

use Illuminate\Support\Facades\Config;
use Mitul456\LaravelMultiRoleAuth\Models\Role;
use Mitul456\LaravelMultiRoleAuth\Models\Permission;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    public function hasAllRoles($roles): bool
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (!$this->hasRole($role)) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        if (!$this->roles->contains($role)) {
            $this->roles()->attach($role);
        }

        return $this;
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        $this->roles()->detach($role);
        return $this;
    }

    public function syncRoles(array $roles)
    {
        $roleIds = [];
        foreach ($roles as $role) {
            if (is_string($role)) {
                $roleModel = Role::where('name', $role)->firstOrFail();
                $roleIds[] = $roleModel->id;
            } else {
                $roleIds[] = $role->id;
            }
        }
        
        $this->roles()->sync($roleIds);
        return $this;
    }

    public function getPrimaryRole()
    {
        $roleHierarchy = Config::get('multirole.role_hierarchy', []);
        
        foreach ($roleHierarchy as $priorityRole) {
            if ($this->hasRole($priorityRole)) {
                return $priorityRole;
            }
        }
        
        return $this->roles->first()->name ?? null;
    }

    public function can($permission, $arguments = []): bool
    {
        if ($this->hasRole('SuperAdmin')) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }

        return false;
    }

    public function getRedirectPath(): string
    {
        $primaryRole = $this->getPrimaryRole();
        $redirectPaths = Config::get('multirole.redirect_paths', []);
        
        return $redirectPaths[$primaryRole] ?? $redirectPaths['default'] ?? '/home';
    }

    public function getHomeRoute(): string
    {
        $primaryRole = $this->getPrimaryRole();
        $homeRoutes = Config::get('multirole.home_routes', []);
        
        return $homeRoutes[$primaryRole] ?? $homeRoutes['default'] ?? 'dashboard';
    }
}