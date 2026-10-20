<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Box;
use App\Models\Document;
use App\Models\Entity;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    private int $page;

    public function __construct(private AuditLogger $logger)
    {
        $this->page = max(1, request()->integer('page', 1));
    }


    public function index()
    {
        return inertia('boxes/index', [
            'boxes' => Box::cached(
                fn() => Box::latest('id')
                    ->paginate(20, page: $this->page)
                    ->toResourceCollection(),
                "boxes:page:{$this->page}"  // [table]:[page]:[number or all]
            )
        ]);
    }


    public function store(StoreBoxRequest $request)
    {
        Gate::authorize('create', Box::class);

        DB::transaction(function () use ($request) {
            $newBox = Box::create($request->validated());
            ($this->logger)(
                $request->user(),
                AuditAction::Add,
                AuditTarget::Box,
                $newBox->box_number
            );
        });

        return back();
    }


    public function show(Box $box)
    {
        Gate::authorize('view', $box);

        return inertia('boxes/Show', [
            'box' => Box::cached(
                fn() => $box->toResource(),
                "box:{$box->id}:show"   // [model]:[number]:show
            ),
            'documents' => Document::cached(
                fn() => $box->documents()
                    ->latest('id')
                    ->paginate(20, page: $this->page)
                    ->toResourceCollection(),
                "box:{$box->id}:page:{$this->page}" // [model]:[number]:page:[number]
            ),
            'boxes' => Box::cached(
                fn() => Box::latest('id')
                    ->get(['id', 'box_number'])
                    ->toResourceCollection(),
                "boxes:page:all"    // [table]:page:all
            ),
            'entities' => Entity::cached(
                fn() => Entity::latest('id')
                    ->get()
                    ->toResourceCollection(),
                "entities:page:all" // [table]:page:all
            ),
        ]);
    }


    public function update(UpdateBoxRequest $request, Box $box)
    {
        Gate::authorize('update', $box);

        DB::transaction(function () use ($request, $box) {
            $box->update($request->validated());
            ($this->logger)(
                $request->user(),
                AuditAction::Edit,
                AuditTarget::Box,
                $box->box_number
            );
        });

        return back();
    }


    public function destroy(Box $box)
    {
        Gate::authorize('delete', $box);

        DB::transaction(function () use ($box) {
            $box->delete();
            ($this->logger)(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::Box,
                $box->box_number
            );
        });

        return to_route('boxes.index');
    }
}
