<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Models\Borrow;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BorrowController extends Controller
{
    public function __construct(private AuditLogger $logger) {}


    public function index(SearchRequest $request)
    {
        return inertia('borrows/index', [
            'borrows' => Borrow::getResources($request, Borrow::query()),
            'filters' => $this->getFilters($request),
        ]);
    }


    public function store(StoreBorrowRequest $request)
    {
        Gate::authorize('create', Borrow::class);
        DB::transaction(function () use ($request) {
            $borrow = Borrow::create($request->validated());
            ($this->logger)(
                $request->user(),
                AuditAction::Add,
                AuditTarget::Borrow,
                $borrow->number
            );
        });

        return back();
    }


    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        Gate::authorize('update', $borrow);
        DB::transaction(function () use ($request, $borrow) {
            $borrow->update($request->validated());
            ($this->logger)(
                $request->user(),
                AuditAction::Edit,
                AuditTarget::Borrow,
                $borrow->number
            );
        });

        return back();
    }


    public function destroy(Borrow $borrow)
    {
        Gate::authorize('delete', $borrow);
        DB::transaction(function () use ($borrow) {
            $borrow->delete();
            ($this->logger)(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::Borrow,
                $borrow->number
            );
        });

        return back();
    }


    private function getFilters(SearchRequest $request)
    {
        return $request->only(['number']);
    }
}
