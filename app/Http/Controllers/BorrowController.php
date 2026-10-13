<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Models\Borrow;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BorrowController extends Controller
{
    public function index()
    {
        return inertia('borrows/index', [
            'borrows' => Borrow::query()
                ->latest('id')
                ->paginate(25)
                ->toResourceCollection()
        ]);
    }


    public function store(StoreBorrowRequest $request)
    {
        Gate::authorize('create', Borrow::class);

        DB::transaction(function () use ($request) {
            $borrow = Borrow::create($request->validated());
            AuditLogger::record(
                Auth::user(),
                AuditAction::Add,
                AuditTarget::Borrow,
                $borrow->doc_number
            );
        });

        return back();
    }


    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        Gate::authorize('update', $borrow);

        DB::transaction(function () use ($request, $borrow) {
            $borrow->fill($request->validated());
            $borrow->save();
            AuditLogger::record(
                Auth::user(),
                AuditAction::Edit,
                AuditTarget::Borrow,
                $borrow->doc_number
            );
        });

        return back();
    }


    public function destroy(Borrow $borrow)
    {
        Gate::authorize('delete', $borrow);

        DB::transaction(function () use ($borrow) {
            $borrow->delete();
            AuditLogger::record(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::Borrow,
                $borrow->doc_number
            );
        });

        return back();
    }
}
