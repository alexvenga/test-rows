<?php

namespace App\Imports;

use App\Models\ExcelRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Importer;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class RowsExcelImport implements ToModel,
                                 WithHeadingRow,
                                 WithCalculatedFormulas,
                                 SkipsEmptyRows,
                                 WithValidation,
                                 SkipsOnFailure,
                                 WithChunkReading,
                                 ShouldQueue
{

    use RemembersRowNumber;
    use Importable {
        Importable::import as public traitImport;
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
        return $this->traitImport($filePath, $disk, $readerType);
    }

    public function rules(): array
    {
        return [
            'id' => 'required|int|min:1',
            'name' => 'required|string|min:1',
            'date' => 'required|numeric',
        ];
    }

    public function model(array $row): ExcelRow|null
    {
        $excelRow = ExcelRow::updateOrCreate([
            'id' => $row['id'],
        ], [
            'name' => $row['name'],
            'date' => Carbon::createFromTimestamp(Date::excelToTimestamp($row['date'])),
        ]);

        cache([$this->getCacheProcessingKey() => $this->getRowNumber()]);

        return $excelRow;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            Log::channel('excel-files')->warning(
                sprintf(
                    'File "%s" upload not valid row %d: %s',
                    $this->currentFilePath,
                    $this->getRowNumber(),
                    implode(' ', $failure->errors())
                )
            );
        }
    }

    protected function getCacheProcessingKey(): string
    {
        return sprintf(
            'upload-excel-processed--%s',
            str($this->currentFilePath)->slug()->toString()
        );
    }

}
