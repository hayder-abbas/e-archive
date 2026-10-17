<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDocument
{
    public function __construct(private AuditLogger $logger) {}


    public function forceDelete(Document $document)
    {
        DB::transaction(function () use ($document) {
            $document->forceDelete();

            ($this->logger)(
                Auth::user(),
                AuditAction::ForceDelete,
                AuditTarget::Document,
                $document->number
            );
        });
    }


    public function softDelete(Document $document)
    {
        DB::transaction(function () use ($document) {
            $document->delete();

            ($this->logger)(
                Auth::user(),
                AuditAction::Delete,
                AuditTarget::Document,
                $document->number
            );
        });
    }
}
