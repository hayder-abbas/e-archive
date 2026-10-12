<?php

namespace App\Policies;

use App\Models\Box;
use App\Models\User;

class BoxPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Box $box): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        return $user->isAdmin();
    }


    public function update(User $user, Box $box): bool
    {
        return $user->isAdmin();
    }


    public function delete(User $user, Box $box): bool
    {
        return $user->isAdmin();
    }


    public function restore(User $user, Box $box): bool
    {
        return false;
    }


    public function forceDelete(User $user, Box $box): bool
    {
        return false;
    }
}
