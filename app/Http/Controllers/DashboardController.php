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
            'documents' => Document::getResources(
                $request,
                Document::query()->with(['box:id,number'])->whereNull('revoked_at')
            ),
            'overView' => [
                'archived' => $doc->all()->count(),
                'incoming' => $doc->where('type', 'Incoming')->count(),
                'outgoing' => $doc->where('type', 'Outgoing')->count(),
                'borrow' => Borrow::all()->count()
            ],
            'keyWord' => $request->keyWord,
        ]);
    }
}
