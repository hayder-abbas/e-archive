<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;
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
        Entity::create($request->validated());
        return back();
    }


    public function update(UpdateEntityRequest $request, Entity $entity)
    {
        Gate::authorize('update', $entity);
        $entity->fill($request->validated());
        $entity->save();
        return back();
    }


    public function destroy(Entity $entity)
    {
        Gate::authorize('delete', $entity);
        $entity->delete();
        return back();
    }
}
