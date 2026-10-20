<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Http\Requests\UpdateEntityRequest;
use App\Models\Entity;
use Illuminate\Support\Facades\Gate;

class EntityController extends Controller
{
    private int $page;

    public function __construct()
    {
        $this->page = max(1, request()->integer('page', 1));
    }


    public function index()
    {
        return inertia('entities/index', [
            'entities' => Entity::cached(
                fn() => Entity::latest('id')
                    ->paginate(20, page: $this->page)
                    ->toResourceCollection(),
                "entities:page:{$this->page}"  // [table]:[page]:[number or all]
            )
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
}
