<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\City;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, City $city): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == UserRole::RW;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, City $city): bool
    {
        return $user->role == UserRole::RW;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, City $city): bool
    {
        return $user->role == UserRole::RW;
    }
}
