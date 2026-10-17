<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Box;
use App\Models\Document;
use App\Models\Entity;
use App\Services\AuditLogger;
use App\Services\DeleteDocument;
use App\Services\StoreDocument;
use App\Services\UpdateDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DocumentController extends Controller
{
    public function __construct(
        private StoreDocument $storeDocument,
        private UpdateDocument $updateDocument,
        private DeleteDocument $deleteDocument,
        private AuditLogger $logger
    ) {}

    public function index()
    {
        return inertia('documents/index', [
            'documents' => Document::query()
                ->with(['box:id,box_number', 'entity'])
                ->latest('id')
                ->paginate(30)
                ->toResourceCollection(),
            'boxes' => Box::latest('id')
                ->get(['id', 'box_number'])
                ->toResourceCollection(),
            'entities' => Entity::latest('id')
                ->get()
                ->toResourceCollection(),
        ]);
    }


    public function show(Document $document)
    {
        return inertia('documents/Show', [
            'document' => $document->toResource(),
            'box' => $document->box->toResource(),
            'entity' => $document->entity->toResource(),
            'boxes' => Box::latest('id')
                ->get(['id', 'box_number'])
                ->toResourceCollection(),
            'entities' => Entity::latest('id')
                ->get()
                ->toResourceCollection(),
        ]);
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


    public function destroy(Document $document)
    {
        Gate::authorize('delete', $document);
        $this->deleteDocument->softDelete($document);

        return to_route('documents.index');
    }


    public function forceDelete(Document $document)
    {
        Gate::authorize('forceDelete', $document);
        $this->deleteDocument->forceDelete($document);

        return back();
    }


    public function restore(Document $document)
    {
        Gate::authorize('restore', $document);

        DB::transaction(function () use ($document) {
            $document->restore();
            ($this->logger)(
                Auth::user(),
                AuditAction::Restore,
                AuditTarget::Document,
                $document->number
            );
        });

        return back();
    }
}
