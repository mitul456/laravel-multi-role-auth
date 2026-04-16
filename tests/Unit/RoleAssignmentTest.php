<?php

namespace Mitul456\LaravelMultiRoleAuth\Tests\Unit;

use Tests\TestCase;
use Mitul456\LaravelMultiRoleAuth\Models\Role;
use Mitul456\LaravelMultiRoleAuth\Traits\HasRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $role;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = \App\Models\User::factory()->create();
        $this->role = Role::create(['name' => 'Editor', 'guard_name' => 'web']);
    }

    /** @test */
    public function user_can_be_assigned_a_role()
    {
        $this->user->assignRole('Editor');
        
        $this->assertTrue($this->user->hasRole('Editor'));
    }

    /** @test */
    public function user_can_have_multiple_roles()
    {
        $role2 = Role::create(['name' => 'Moderator', 'guard_name' => 'web']);
        
        $this->user->assignRole('Editor');
        $this->user->assignRole('Moderator');
        
        $this->assertTrue($this->user->hasRole('Editor'));
        $this->assertTrue($this->user->hasRole('Moderator'));
        $this->assertEquals(2, $this->user->roles->count());
    }

    /** @test */
    public function user_can_remove_role()
    {
        $this->user->assignRole('Editor');
        $this->assertTrue($this->user->hasRole('Editor'));
        
        $this->user->removeRole('Editor');
        $this->assertFalse($this->user->hasRole('Editor'));
    }

    /** @test */
    public function user_can_sync_roles()
    {
        Role::create(['name' => 'User', 'guard_name' => 'web']);
        
        $this->user->assignRole('Editor');
        $this->user->syncRoles(['User']);
        
        $this->assertFalse($this->user->hasRole('Editor'));
        $this->assertTrue($this->user->hasRole('User'));
        $this->assertEquals(1, $this->user->roles->count());
    }
}