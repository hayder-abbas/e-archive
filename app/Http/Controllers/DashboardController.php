<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Borrow;
use App\Models\Document;

class DashboardController extends Controller
{
    public function index(SearchRequest $request)
    {
        $doc = new Document();

        return inertia('Dashboard', [
            'documents' => $doc::getResources($request, $doc->query()->with(['box:id,number'])),
            'overView' => [
                'archived' => $doc->whereNull('revoked_at')->count(),
                'incoming' => $doc->where('type', 'Incoming')->count(),
                'outgoing' => $doc->where('type', 'Outgoing')->count(),
                'borrow'   => Borrow::query()->count()
            ],
            'keyWord' => $request->keyWord,
        ]);
    }
}
