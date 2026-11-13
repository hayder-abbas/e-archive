<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use thiagoalessio\TesseractOCR\TesseractOCR;

class PdfOcr
{
    public function extract(string $pdf, array $langs): string
    {
        $dir = sys_get_temp_dir() . '/ocr-' . Str::uuid();
        File::ensureDirectoryExists($dir);

        try {
            Process::timeout(120)
                ->run(['pdftoppm', '-r', '200', '-gray', '-l', '2', '-png', $pdf, "{$dir}/page"])
                ->throw();

            return collect(File::glob("$dir/page-*.png"))
                ->sort(SORT_NATURAL)
                ->map(fn($image) => (new TesseractOCR($image))->lang(...$langs)->run())
                ->implode("\n\n");
        } finally {
            File::deleteDirectory($dir);
        }
    }
}
