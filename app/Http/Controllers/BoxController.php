<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Box;
use App\Models\Doc;
use Inertia\Inertia;

class BoxController extends Controller
{
    public function index()
    {
        return inertia('boxes/index', [
            'boxes' => Box::query()
                ->latest('box_date')
                ->paginate(30)
                ->toResourceCollection()
        ]);
    }


    public function store(StoreBoxRequest $request)
    {
        Gate::authorize('create', Box::class);
        Box::create($request->validated());
        return back();
    }


    public function show(Box $box)
    {
        Gate::authorize('view', $box);
        return inertia('boxes/Show', [
            'docs' => Doc::query()
                ->with('box')
                ->where('box_id', $box->id)
                ->latest('date')
                ->paginate(30)
                ->toResourceCollection(),
            'box' => $box->toResource()
        ]);
    }


    public function update(UpdateBoxRequest $request, Box $box)
    {
        Gate::authorize('update', $box);
        $box->fill($request->validated());
        $box->save();
        return back();
    }


    public function destroy(Box $box)
    {
        Gate::authorize('delete', $box);
        $box->delete();
        return redirect(route('boxes.index'));
    }
}
