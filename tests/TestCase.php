<?php

namespace Tests;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsSuperadmin(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => UserRole::Superadmin]));
    }
}
