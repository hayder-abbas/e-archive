<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $user): bool
    {
        return $user->isSudo();
    }


    public function delete(User $user): bool
    {
        return $user->isSudo();
    }


    public function addRole(User $user): bool
    {
        return $user->isSudo();
    }
}
