<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;
use App\Models\Borrow;
use Illuminate\Support\Facades\Gate;

class BorrowController extends Controller
{
    public function index()
    {
        return inertia('borrows/index', [
            'borrows' => Borrow::query()
                ->latest('id')
                ->paginate(25)
                ->toResourceCollection()
        ]);
    }


    public function store(StoreBorrowRequest $request)
    {
        Gate::authorize('create', Borrow::class);
        Borrow::create($request->validated());
        return back();
    }


    public function update(UpdateBorrowRequest $request, Borrow $borrow)
    {
        Gate::authorize('update', $borrow);
        $borrow->fill($request->validated());
        $borrow->save();
        return back();
    }


    public function destroy(Borrow $borrow)
    {
        Gate::authorize('delete', $borrow);
        $borrow->delete();
        return back();
    }
}
