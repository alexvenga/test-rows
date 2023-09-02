<?php

namespace App\Http\Controllers\Rows;

use App\Http\Controllers\Controller;
use App\Models\ExcelRow;
use Illuminate\Http\Request;

class ViewRowsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $excelRows = ExcelRow::query()
            ->selectRaw('date, COUNT(*) as excel_rows_count')
            ->groupBy('date')
            ->orderByDesc('date')
            ->pluck('excel_rows_count', 'date');
        //fn($row)=>$row->date->format('Y-m-d')

        return view('rows.index', compact('excelRows'));
    }
}
