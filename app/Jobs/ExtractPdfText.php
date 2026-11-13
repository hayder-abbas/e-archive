<?php

namespace App\Jobs;

use App\Models\Document;
use App\Services\CleansText;
use App\Services\PdfOcr;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ExtractPdfText implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(public Document $document) {}

    public function handle(): void
    {
        if (!$this->document->file || !Storage::exists($this->document->file)) {
            return;
        }

        $text = app(PdfOcr::class)->extract(Storage::path($this->document->file), ['eng', 'ara']);
        $content = app(CleansText::class)->prepareText($text);

        $this->document->update(['content' => $content !== '' ? $content : null]);
    }

    public function failed(\Throwable $th): void
    {
        report($th);
    }
}
