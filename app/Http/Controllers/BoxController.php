<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Box;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
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
            AuditLogger::record(
                Auth::user(),
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
            'docs' => $box->docs()
                ->latest('id')
                ->paginate(25)
                ->toResourceCollection(),
            'box' => $box->toResource()
        ]);
    }


    public function update(UpdateBoxRequest $request, Box $box)
    {
        Gate::authorize('update', $box);

        DB::transaction(function () use ($request, $box) {
            $box->fill($request->validated());
            $box->save();
            AuditLogger::record(
                Auth::user(),
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
            AuditLogger::record(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::Box,
                $box->box_number
            );
        });

        return to_route('boxes.index');
    }
}
