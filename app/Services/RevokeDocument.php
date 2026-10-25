<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevokeDocument
{
    public function __construct(private AuditLogger $logger) {}


    public function revoke(Document $document)
    {
        return DB::transaction(function () use ($document) {
            $document->update([
                'revoked_at' => now()
            ]);

            ($this->logger)(
                Auth::user(),
                AuditAction::Revoke,
                AuditTarget::Document,
                $document->number
            );

            return $document->revoked_at;
        });
    }


    public function reinstate(Document $document)
    {
        return DB::transaction(function () use ($document) {
            $document->update([
                'revoked_at' => null
            ]);

            ($this->logger)(
                Auth::user(),
                AuditAction::Reinstate,
                AuditTarget::Document,
                $document->number
            );

            return $document->revoked_at;
        });
    }
}
