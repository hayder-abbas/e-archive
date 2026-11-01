<?php

namespace App\Policies;

use App\Models\AuditLog;
use App\Models\User;

class AuditLogPolicy
{
    public function viewAny(User $user): bool
    {
        return !!$user;
    }


    public function view(User $user, AuditLog $auditLog): bool
    {
        return !!$user;
    }


    public function create(User $user): bool
    {
        return $user->isSudo() || $user->isAdmin();
    }


    public function delete(User $user): bool
    {
        return $user->isSudo();
    }


    public function restore(User $user, AuditLog $auditLog): bool
    {
        return false;
    }


    public function forceDelete(User $user, AuditLog $auditLog): bool
    {
        return false;
    }
}
