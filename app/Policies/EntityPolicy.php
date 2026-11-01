<?php

namespace App\Policies;

use App\Models\Entity;
use App\Models\User;

class EntityPolicy
{
    public function viewAny(User $user): bool
    {
        return !!$user;
    }


    public function view(User $user, Entity $entity): bool
    {
        return !!$user;
    }


    public function create(User $user): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function update(User $user, Entity $entity): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function delete(User $user, Entity $entity): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function restore(User $user, Entity $entity): bool
    {
        return false;
    }


    public function forceDelete(User $user, Entity $entity): bool
    {
        return false;
    }
}
