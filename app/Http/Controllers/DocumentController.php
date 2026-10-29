<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Box;
use App\Models\Document;
use App\Models\Entity;
use App\Services\RevokeDocument;
use App\Services\StoreDocument;
use App\Services\UpdateDocument;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct(
        private StoreDocument $storeDocument,
        private UpdateDocument $updateDocument,
        private RevokeDocument $revokeDocument,
    ) {}


    public function index(SearchRequest $request)
    {
        Gate::authorize('viewAny', Document::class);
        return inertia('documents/index', [
            'documents' => Document::getResources(
                $request,
                Document::query()->with(['box:id,number'])->whereNull('revoked_at')
            ),
            'boxes' => $this->getBoxes(),
            'entities' => $this->getEntities(),
            'filters' => $this->getFilters($request),
        ]);
    }


    public function show(Document $document)
    {
        Gate::authorize('view', $document);
        return inertia('documents/Show', [
            'document' => $document->load(['box:id,number', 'entity'])->toResource(),
            'followers' => $document->followers(),
            'boxes' => $this->getBoxes(),
            'entities' => $this->getEntities(),
        ]);
    }


    public function showFile(Document $document)
    {
        Gate::authorize('view', $document);
        abort_unless(Storage::exists($document->file), 404);
        return Storage::response($document->file);
    }


    public function store(StoreDocumentRequest $request)
    {
        Gate::authorize('create', Document::class);
        ($this->storeDocument)($request);
        return back();
    }


    public function update(UpdateDocumentRequest $request, Document $document)
    {
        Gate::authorize('update', $document);
        ($this->updateDocument)($request, $document);
        return back();
    }


    public function revoke(Document $document)
    {
        Gate::authorize('revoke', $document);
        $this->revokeDocument->revoke($document);
        return back();
    }


    public function reinstate(Document $document)
    {
        Gate::authorize('reinstate', $document);
        $this->revokeDocument->reinstate($document);
        return back();
    }


    public function revokeds(SearchRequest $request)
    {
        Gate::authorize('viewAny', Document::class);
        return inertia('Revokeds', [
            'revokeds' => Document::getResources(
                $request,
                Document::query()->with('box:id,number')->whereNotNull('revoked_at')
            ),
            'filters' => $this->getFilters($request),
        ]);
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
