<?php

namespace App\Imports;

use App\Models\Row;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImport implements ToModel
{

    public function model(array $row): Row|null
    {
        return new Row([
            'id' => $row[0],
            'name' => $row[1],
            'date' => Carbon::createFromFormat('d.m.y', $row[2]),
        ]);
    }

}
