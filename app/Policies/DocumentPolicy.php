<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return !!$user;
    }


    public function view(User $user, Document $document): bool
    {
        return !!$user;
    }


    public function create(User $user): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function update(User $user, Document $document): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function revoke(User $user, Document $document): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function reinstate(User $user, Document $document): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function delete(User $user, Document $document): bool
    {
        return false;
    }


    public function restore(User $user, Document $document): bool
    {
        return false;
    }


    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }
}
