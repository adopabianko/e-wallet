<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Hash;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanAccessRegisterForm()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testUserCanRegister()
    {
        $user = [
            'name' => 'User Test',
            'email' => 'user@test.com',
            'phone_number' => '081283781369',
            'password' => 'admin123',
            'password_confirmation' => 'admin123',
            'token' => Hash::make('user@test.com'),
        ];

        $response = $this->post('/register', $user);
        
        $response->assertRedirect('/home');
    }

    public function testUserCanAccessLoginForm()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testUserCanLogin()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/home');
    }
}