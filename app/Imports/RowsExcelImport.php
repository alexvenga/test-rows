<?php

namespace App\Imports;

use App\Models\Row;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    use Importable;

    public function rules(): array
    {
        return [
            'id' => 'required|int|min:1',
            'name' => 'required|string|min:1',
            'date' => 'required|numeric',
        ];
    }

    public function model(array $row): Row|null
    {
        return Row::updateOrCreate([
            'id' => $row['id'],
        ], [
            'name' => $row['name'],
            'date' => Carbon::createFromTimestamp(Date::excelToTimestamp($row['date'])),
        ]);
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

        $currentRowNumber = $this->getRowNumber();

        foreach ($failures as $failure) {
            Log::channel('excel-files')->warning(
                sprintf(
                    'File upload not valid row %d: %s',
                    $currentRowNumber,
                    implode(' ', $failure->errors())
                )
            );
        }
    }

}
