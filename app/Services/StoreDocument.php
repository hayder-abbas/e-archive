<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreDocument
{
    public function __construct(private AuditLogger $logger) {}

    public function __invoke(StoreDocumentRequest $request): Document
    {
        $fields = $request->validated();
        $boxId = $fields['box_id'];
        $storePath = "pdfs/{$boxId}";
        $filePath = null;

        try {
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store($storePath);
                $fields['file'] = $filePath;
            }

            return DB::transaction(function () use ($fields, $request) {
                $document = Document::create($fields);

                ($this->logger)(
                    $request->user(),
                    AuditAction::Add,
                    AuditTarget::Document,
                    $fields['number']
                );

                return $document;
            });
        } catch (\Throwable $th) {
            if ($filePath) {
                Storage::disk()->delete($filePath);
            }
            throw $th;
        }
    }
}
