<?php

namespace App\Imports;

use App\Models\ExcelRow;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RowsExcelImport extends AbstractExcelImporter
{

    public function rules(): array
    {
        return [
            'id' => 'required|int|min:1',
            'name' => 'required|string|min:1',
            'date' => 'required|numeric',
        ];
    }

    public function makeModel(array $row): ExcelRow|null
    {
        return ExcelRow::updateOrCreate([
            'id' => $row['id'],
        ], [
            'name' => $row['name'],
            'date' => Carbon::createFromTimestamp(Date::excelToTimestamp($row['date'])),
        ]);
    }

}
