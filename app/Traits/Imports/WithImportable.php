<?php

namespace App\Traits\Imports;

use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Importer;

trait WithImportable
{

    use Importable {
        Importable::import as public parentImport;
    }

    protected ?string $currentFilePath = null;

    /**
     * Override Importable::import for save current file path
     *
     * @param $filePath
     * @param  string|null  $disk
     * @param  string|null  $readerType
     * @return Importer|PendingDispatch
     */
    public function import($filePath = null, string $disk = null, string $readerType = null): Importer|PendingDispatch
    {
        $this->currentFilePath = $filePath;
        return $this->parentImport($filePath, $disk, $readerType);
    }

    protected function getCacheProcessingKey(): string
    {
        return sprintf(
            'upload-excel-processed--%s',
            str($this->currentFilePath)->slug()->toString()
        );
    }

    protected function incrementCacheProcessing(): void
    {
        if (!Cache::has($this->getCacheProcessingKey())) {
            Cache::put($this->getCacheProcessingKey(), 1, now()->addDay());
        }

        Cache::increment($this->getCacheProcessingKey());
    }

    protected function getCacheProcessing(): int
    {
        return Cache::get($this->getCacheProcessingKey()) ?? 0;
    }

}
