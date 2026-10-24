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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    private int $page;

    public function __construct(
        private StoreDocument $storeDocument,
        private UpdateDocument $updateDocument,
        private DeleteDocument $deleteDocument,
        private AuditLogger $logger
    ) {
        $this->page = max(1, request()->integer('page', 1));
    }

    public function index()
    {
        Gate::authorize('viewAny', Document::class);

        return inertia('documents/index', [
            'documents' => Document::cached(
                fn() => Document::query()
                    ->with(['box:id,box_number', 'entity'])
                    ->latest('id')
                    ->paginate(30, page: $this->page)
                    ->toResourceCollection(),
                "documents:page:{$this->page}"  // [table]:[page]:[number or all]
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


    public function show(Document $document)
    {
        Gate::authorize('view', $document);

        return inertia('documents/Show', [
            'document' => Document::cached(
                fn() => $document
                    ->load(['box:id,box_number', 'entity'])
                    ->toResource(),
                "document:{$document->id}:show" // [model]:[number]:show
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
            'followers' => Document::cached(
                fn() => $document->followers()->toResourceCollection(),
                "document:{$document->id}:followers:all"
            ),
        ]);
    }


    public function showFile(Document $document)
    {
        Gate::authorize('view', $document);
        abort_unless(Storage::exists($document->file), 404);

        return Storage::response(
            $document->file,
            Str::slug($document->number) . '.pdf'
        );
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


    public function trash()
    {
        Gate::authorize('viewAny', Document::class);

        return inertia('Trash', [
            'documents' => Document::cached(
                fn() => Document::onlyTrashed()
                    ->with(['box:id,box_number'])
                    ->paginate(20, page: $this->page)
                    ->toResourceCollection(),
                "trash:page:{$this->page}"  // trash:page:[number]
            )
        ]);
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
