<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    public function test_register_user()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Alex',
            'email' => 'alex@mail.ru',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ]);
        $response->assertStatus(200)->assertJson([
            'status' => 'Success'
        ]);
    }
    public function test_login_user()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'alex@mail.ru',
            'password' => 'test1234']);
        $response->assertStatus(200);
    }
    public function test_logout_user() {
        $user = User::factory()->create();
        $token = $user->createToken('Your personal token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');
        $response->assertStatus(200);
    }
}
