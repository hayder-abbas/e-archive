<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateDocument
{
    public function __construct(private AuditLogger $logger) {}

    public function __invoke(UpdateDocumentRequest $request, Document $document): Document
    {
        $fields = $request->validated();
        $boxId = $fields['box_id'];
        $storePath = "pdfs/{$boxId}";
        $oldPath  = $document->file;
        $baseFileName = basename($oldPath);
        $newPath  = null;
        $undo     = null;
        $replaced = false;
        $moved    = false;

        try {
            if ($request->hasFile('file')) {
                $newPath = $request->file('file')->store($storePath);
                $undo = fn() => Storage::delete($newPath);

                $fields['file'] = $newPath;
                $replaced = true;
            } elseif ((int) $boxId !== (int) $document->box_id && $baseFileName !== '') {
                $newPath = "{$storePath}/{$baseFileName}";
                $undo = fn() => Storage::move($newPath, $oldPath);

                $fields['file'] = $newPath;
                $moved = true;
            }

            DB::transaction(function () use ($document, $fields, $request) {
                $document->update($fields);

                ($this->logger)(
                    $request->user(),
                    AuditAction::Edit,
                    AuditTarget::Document,
                    $document->number
                );
            });
        } catch (\Throwable $th) {
            if ($undo) rescue($undo);
            throw $th;
        }

        if ($replaced) rescue(fn() => Storage::delete($oldPath));

        if ($moved) rescue(fn() => Storage::move($oldPath, $newPath));

        return $document;
    }
}
