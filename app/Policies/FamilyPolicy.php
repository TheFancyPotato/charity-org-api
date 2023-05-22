<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Family;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamilyPolicy
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
    public function view(User $user, Family $family): bool
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
    public function update(User $user, Family $family): bool
    {
        return $user->role == UserRole::RW;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Family $family): bool
    {
        return $user->role == UserRole::RW;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Family $family): bool
    {
        return $user->role == UserRole::RW;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Family $family): bool
    {
        return $user->role == UserRole::RW;
    }
}
