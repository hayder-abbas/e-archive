<?php

namespace App\Policies;

use App\Models\Box;
use App\Models\User;

class BoxPolicy
{
    public function viewAny(User $user): bool
    {
        return !!$user;
    }


    public function view(User $user, Box $box): bool
    {
        return !!$user;
    }


    public function create(User $user): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function update(User $user, Box $box): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function delete(User $user, Box $box): bool
    {
        return false;
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
