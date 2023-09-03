<?php

namespace App\Imports;

use App\Traits\Imports\WithImportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

abstract class AbstractExcelImporter implements WithCalculatedFormulas, SkipsEmptyRows, SkipsOnFailure, WithChunkReading,
                                                WithHeadingRow, ShouldQueue, ToModel,
                                                WithValidation
{

    use WithImportable;

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function onFailure(Failure ...$failures): void
    {
        $this->incrementCacheProcessing();

        foreach ($failures as $failure) {
            Log::channel('excel-files')->warning(
                sprintf(
                    'File "%s" upload not valid row %d: %s',
                    $this->currentFilePath,
                    $this->getCacheProcessing(),
                    implode(' ', $failure->errors())
                )
            );
        }
    }

    public function model(array $row): Model|array|null
    {
        $this->incrementCacheProcessing();

        return $this->makeModel($row);
    }

    abstract public function makeModel(array $row): Model|array|null;

    abstract public function rules(): array;


}
