<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserLogin()
    {
        $user = User::factory()->create([
            'password' => Hash::make('12345678')
        ]);

        $res = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        $res->assertOk()
            ->assertJsonStructure(['token'])
            ->assertJson([
                'message' => 'Logged in successfully',
            ]);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->post('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => 'Logged out successfully.',
            ]);
    }
}
