<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Box;
use App\Models\Document;
use App\Models\Entity;
use App\Services\StoreBox;
use App\Services\UpdateBox;

class BoxController extends Controller
{
    private int $page;

    public function __construct(
        private StoreBox $storeBox,
        private UpdateBox $updateBox
    ) {
        $this->page = max(1, request()->integer('page', 1));
    }


    public function index()
    {
        Gate::authorize('viewAny', Box::class);

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

        ($this->storeBox)($request);

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

        ($this->updateBox)($request, $box);

        return back();
    }
}
