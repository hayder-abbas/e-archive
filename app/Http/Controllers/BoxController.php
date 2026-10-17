<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Box;
use App\Models\Entity;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    public function __construct(private AuditLogger $logger) {}

    public function index()
    {
        return inertia('boxes/index', [
            'boxes' => Box::latest('id')
                ->paginate(10)
                ->toResourceCollection()
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
            'documents' => $box->documents()
                ->latest('id')
                ->paginate(20)
                ->toResourceCollection(),
            'box' => $box->toResource(),
            'boxes' => Box::latest('id')
                ->get(['id', 'box_number'])
                ->toResourceCollection(),
            'entities' => Entity::latest('id')
                ->get()
                ->toResourceCollection(),
        ]);
    }


    public function update(UpdateBoxRequest $request, Box $box)
    {
        Gate::authorize('update', $box);

        DB::transaction(function () use ($request, $box) {
            $box->fill($request->validated());
            $box->save();
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
