<?php

namespace App\Policies;

use App\Models\Entity;
use App\Models\User;

class EntityPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function view(User $user, Entity $entity): bool
    {
        return false;
    }


    public function create(User $user): bool
    {
        return $user->isAdmin();
    }


    public function update(User $user, Entity $entity): bool
    {
        return $user->isAdmin();
    }


    public function delete(User $user, Entity $entity): bool
    {
        return $user->isAdmin();
    }


    public function restore(User $user, Entity $entity): bool
    {
        return $user->isAdmin();
    }


    public function forceDelete(User $user, Entity $entity): bool
    {
        return $user->isAdmin();
    }
}
