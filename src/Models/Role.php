<?php

namespace Mitul456\LaravelMultiRoleAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mitul456\LaravelMultiRoleAuth\Contracts\RoleInterface;

class Role extends Model implements RoleInterface
{
    use SoftDeletes;

    protected $fillable = ['name', 'guard_name', 'description', 'priority'];

    protected $casts = [
        'priority' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }
        
        if (!$this->permissions->contains($permission)) {
            $this->permissions()->attach($permission);
        }
        
        return $this;
    }

    public function revokePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }
        
        $this->permissions()->detach($permission);
        return $this;
    }

    public function syncPermissions(array $permissions)
    {
        $permissionIds = [];
        foreach ($permissions as $permission) {
            if (is_string($permission)) {
                $permModel = Permission::where('name', $permission)->firstOrFail();
                $permissionIds[] = $permModel->id;
            } else {
                $permissionIds[] = $permission->id;
            }
        }
        
        $this->permissions()->sync($permissionIds);
        return $this;
    }

    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        
        return false;
    }
}