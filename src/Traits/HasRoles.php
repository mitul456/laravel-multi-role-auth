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
        // Ensure roles are loaded
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }
        
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
        
        if ($roles instanceof Role) {
            return $this->roles->contains('id', $roles->id);
        }
        
        return false;
    }

    public function hasAllRoles($roles): bool
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }
        
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        
        if (is_array($roles)) {
            $userRoleNames = $this->roles->pluck('name')->toArray();
            return !array_diff($roles, $userRoleNames);
        }
        
        return false;
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
            if (!$role) {
                throw new \Exception("Role '{$role}' not found");
            }
        }
        
        if (!$this->roles->contains($role)) {
            $this->roles()->attach($role);
            $this->load('roles'); // Reload after assignment
        }
        
        return $this;
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role && $this->roles->contains($role)) {
            $this->roles()->detach($role);
            $this->load('roles'); // Reload after removal
        }
        
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
        $this->load('roles'); // Reload after sync
        
        return $this;
    }

    public function getPrimaryRole()
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }
        
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
        
        if (!$this->relationLoaded('roles')) {
            $this->load('roles.permissions');
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