<?php

use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function testUserListingWithPagination()
    {
        $this->actingAsSuperadmin();

        User::factory()->count(15)->create();

        $perPage = 5;
        $page = 2;

        $response = $this->json('GET', '/api/users', [
            'page' => $page,
            'per_page' => $perPage,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
            ])
            ->assertJson([
                'meta' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                ]
            ])
            ->assertJsonCount($perPage, 'data');
    }

    public function testUserCreation()
    {
        $this->actingAsSuperadmin();

        $this->post('/api/users', [
            'name' => 'Mahdi Mohammed',
            'email' => 'mahdi@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => UserRole::RW->value,
        ])->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => 'Mahdi Mohammed',
            'email' => 'mahdi@example.com',
        ]);
    }

    public function testUserUpdate()
    {
        $this->actingAsSuperadmin();

        $user = User::factory()->create();

        $this->put('/api/users/' . $user->id, [
            'name' => 'Ibraheem',
            'email' => 'ibraheem@example.com',
            'role' => UserRole::RW->value,
        ])->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Ibraheem',
            'email' => 'ibraheem@example.com',
        ]);
    }

    public function testUserDeletion()
    {
        $this->actingAsSuperadmin();

        $user = User::factory()->create();

        $this->delete('/api/users/' . $user->id)->assertNoContent();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function testUserRetrieval()
    {
        $this->actingAsSuperadmin();

        $user = User::factory()->create();

        $this->get('/api/users/' . $user->id)
            ->assertStatus(200)
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.name', $user->name)
            ->assertJsonPath('data.email', $user->email)
            ->assertJsonPath('data.role', $user->role->value);
    }
}
