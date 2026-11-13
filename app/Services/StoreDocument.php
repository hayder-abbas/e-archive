<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreDocumentRequest;
use App\Jobs\ExtractPdfText;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreDocument
{
    private const DISK = 'local';

    public function __construct(private AuditLogger $logger) {}

    public function __invoke(StoreDocumentRequest $request): Document
    {
        $fields = $request->validated();
        $filePath = null;

        try {
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('pdfs/' . $fields['box_id'], self::DISK);
                if (!$filePath) throw new \RuntimeException('Failed to store the uploaded file.');
                $fields['file'] = $filePath;
            }

            $newDocument = DB::transaction(function () use ($fields, $request) {
                $document = Document::create($fields);

                ($this->logger)(
                    $request->user(),
                    AuditAction::Add,
                    AuditTarget::Document,
                    $document->number
                );

                if (isset($fields['file'])) ExtractPdfText::dispatch($document)->afterCommit();

                return $document;
            });
        } catch (\Throwable $th) {
            if ($filePath) {
                Storage::disk(self::DISK)->delete($filePath);
            }
            throw $th;
        }

        return $newDocument;
    }
}
