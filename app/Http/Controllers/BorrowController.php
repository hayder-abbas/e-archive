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
    private int $page;

    public function __construct(private AuditLogger $logger)
    {
        $this->page = max(1, request()->integer('page', 1));
    }


    public function index()
    {
        return inertia('borrows/index', [
            'borrows' => Borrow::cached(
                fn() => Borrow::latest('id')
                    ->paginate(20, page: $this->page)
                    ->toResourceCollection(),
                "borrows:page:{$this->page}"    // [table]:[page]:[number or all]
            )
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
                $borrow->doc_number
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
            ($this->logger)(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::Borrow,
                $borrow->doc_number
            );
        });

        return back();
    }
}
