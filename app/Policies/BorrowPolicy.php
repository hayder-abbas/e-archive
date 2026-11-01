<?php

namespace App\Policies;

use App\Models\Borrow;
use App\Models\User;

class BorrowPolicy
{
    public function viewAny(User $user): bool
    {
        return !!$user;
    }


    public function view(User $user, Borrow $borrow): bool
    {
        return !!$user;
    }


    public function create(User $user): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function update(User $user, Borrow $borrow): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function delete(User $user, Borrow $borrow): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function restore(User $user, Borrow $borrow): bool
    {
        return false;
    }


    public function forceDelete(User $user, Borrow $borrow): bool
    {
        return false;
    }
}
