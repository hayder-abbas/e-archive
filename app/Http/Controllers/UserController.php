<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(private AuditLogger $logger) {}


    public function index()
    {
        $user = new User();
        Gate::authorize('view', $user);

        return inertia('settings/Users', [
            'users' => User::simplePaginate(10)->toResourceCollection(),
        ]);
    }


    public function setAsAdmin(User $user)
    {
        Gate::authorize('addRole', $user);

        DB::transaction(function () use ($user) {
            $user->update(['role' => 'admin']);

            ($this->logger)(
                Auth::user(),
                AuditAction::AddRole,
                AuditTarget::Admin,
                $user->id
            );
        });

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('settings.flash_set_admin')
        ])->back();
    }


    public function setAsUser(User $user)
    {
        Gate::authorize('addRole', $user);

        DB::transaction(function () use ($user) {
            $user->update(['role' => 'user']);

            ($this->logger)(
                Auth::user(),
                AuditAction::AddRole,
                AuditTarget::User,
                $user->id
            );
        });

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('settings.flash_set_user')
        ])->back();
    }


    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        DB::transaction(function () use ($user) {
            $user->delete();

            ($this->logger)(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::User,
                $user->id
            );
        });

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('settings.flash_delete_user')
        ])->back();
    }
}
