<?php

namespace Mitul456\LaravelMultiRoleAuth\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Mitul456\LaravelMultiRoleAuth\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_gets_redirected_to_role_specific_dashboard_after_login()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        
        $response->assertRedirect('/admin/dashboard');
    }

    /** @test */
    public function role_middleware_blocks_unauthorized_access()
    {
        $user = User::factory()->create();
        $user->assignRole('User');
        
        $response = $this->actingAs($user)
            ->get('/admin/dashboard');
        
        $response->assertStatus(403);
    }
}