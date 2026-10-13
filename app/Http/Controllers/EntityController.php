<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\AuditLog;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EntityController extends Controller
{
    public function index()
    {
        return inertia('entities/index', [
            'entities' => Entity::query()
                ->latest('id')
                ->get()
                ->toResourceCollection()
        ]);
    }


    public function store(StoreEntityRequest $request)
    {
        Gate::authorize('create', Entity::class);
        DB::transaction(function () use ($request) {
            $entity = Entity::create($request->validated());
            AuditLog::create([
                'name' => Auth::user()->name,
                'action' => 'Add entity: ' . $entity->name
            ]);
        });
        return back();
    }


    public function update(UpdateEntityRequest $request, Entity $entity)
    {
        Gate::authorize('update', $entity);
        DB::transaction(function () use ($request, $entity) {
            $entity->fill($request->validated());
            $entity->save();
            AuditLog::create([
                'name' => Auth::user()->name,
                'action' => 'Edit entity: ' . $entity->name
            ]);
        });
        return back();
    }


    public function destroy(Entity $entity)
    {
        Gate::authorize('delete', $entity);
        DB::transaction(function () use ($entity) {
            $entity->delete();
            AuditLog::create([
                'name' => Auth::user()->name,
                'action' => 'Delete entity: ' . $entity->name
            ]);
        });
        return back();
    }
}
