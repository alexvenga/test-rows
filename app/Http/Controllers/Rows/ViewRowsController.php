<?php

namespace App\Http\Controllers\Rows;

use App\Http\Controllers\Controller;
use App\Models\ExcelRow;
use App\Models\Row;
use Illuminate\Http\Request;

class ViewRowsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rows = ExcelRow::selectRaw('date, name, COUNT(*) as excel_rows_count')->get();

        dd($rows);
    }
}
