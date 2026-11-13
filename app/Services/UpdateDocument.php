<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\UpdateDocumentRequest;
use App\Jobs\ExtractPdfText;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateDocument
{
    private const DISK = 'local';

    public function __construct(private AuditLogger $logger) {}

    public function __invoke(UpdateDocumentRequest $request, Document $document): Document
    {
        $fields = $request->validated();
        $boxId = $fields['box_id'];
        $storeDir = "pdfs/{$boxId}";
        $oldPath  = $document->file;
        $newPath  = null;
        $undo     = null;
        $replaced = false;

        try {
            if ($request->hasFile('file')) {
                // Store
                $newPath = $request->file('file')->store($storeDir, self::DISK);
                $undo = fn() => Storage::delete($newPath);

                if (!$newPath) throw new \RuntimeException('Failed to store the uploaded file.');
                $fields['file'] = $newPath;
                $fields['content'] = null;
                $replaced = true;
            } elseif ($oldPath && (int) $boxId !== (int) $document->box_id) {
                // Move
                $newPath = "{$storeDir}/" . basename($oldPath);
                Storage::disk(self::DISK)->move($oldPath, $newPath) || throw new \RuntimeException("Could not move {$oldPath}");

                $undo = fn() => Storage::move($newPath, $oldPath);
                $fields['file'] = $newPath;
            }

            DB::transaction(function () use ($document, $fields, $request) {
                $document->update($fields);

                ($this->logger)(
                    $request->user(),
                    AuditAction::Edit,
                    AuditTarget::Document,
                    $document->number
                );

                if (isset($fields['file'])) ExtractPdfText::dispatch($document)->afterCommit();
            });
        } catch (\Throwable $th) {
            if ($undo) rescue($undo);
            $replaced = false;
            throw $th;
        }

        if ($replaced && !!$oldPath) rescue(fn() => Storage::delete($oldPath));

        return $document;
    }
}
