<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;
use Illuminate\Support\Facades\Gate;

class EntityController extends Controller
{
    public function index(SearchRequest $request)
    {
        return inertia('entities/index', [
            'entities' => Entity::getResources($request, Entity::query()),
            'filters' => $this->getFilters($request),
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
        $entity->update($request->validated());
        return back();
    }


    public function destroy(Entity $entity)
    {
        Gate::authorize('delete', $entity);
        $entity->delete();
        return back();
    }


    private function getFilters(SearchRequest $request)
    {
        return $request->only(['name']);
    }
}
