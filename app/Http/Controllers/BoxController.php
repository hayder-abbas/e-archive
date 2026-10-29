<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Box;
use App\Models\Entity;
use App\Services\StoreBox;
use App\Services\UpdateBox;

class BoxController extends Controller
{
    public function __construct(private StoreBox $storeBox, private UpdateBox $updateBox) {}


    public function index(SearchRequest $request)
    {
        Gate::authorize('viewAny', Box::class);
        return inertia('boxes/index', [
            'boxes' => Box::getResources($request, Box::query()),
            'filters' => $this->getFilters($request),
        ]);
    }


    public function show(Box $box, SearchRequest $request)
    {
        Gate::authorize('view', $box);
        return inertia('boxes/Show', [
            'documents' => Box::getResources(
                $request,
                $box->documents()->getQuery()->whereNull('revoked_at')
            ),
            'box' => $box->toResource(),
            'boxes' => $this->getBoxes(),
            'entities' => $this->getEntities(),
            'filters' => $this->getFilters($request),
        ]);
    }


    public function store(StoreBoxRequest $request)
    {
        Gate::authorize('create', Box::class);
        ($this->storeBox)($request);
        return back();
    }


    public function update(UpdateBoxRequest $request, Box $box)
    {
        Gate::authorize('update', $box);
        ($this->updateBox)($request, $box);
        return back();
    }


    private function getBoxes()
    {
        return Box::cached(
            fn() => Box::latest('id')
                ->get(['id', 'number'])
                ->toResourceCollection(),
            "boxes:page:all"    // [table]:page:all
        );
    }


    private function getEntities()
    {
        return Entity::cached(
            fn() => Entity::latest('id')
                ->get()
                ->toResourceCollection(),
            "entities:page:all" // [table]:page:all
        );
    }


    private function getFilters(SearchRequest $request)
    {
        return $request->only(
            ['number', 'fromDate', 'toDate', 'typeFilter']
        );
    }
}
