<?php

namespace App\Http\Controllers\Rows;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rows\UploadRowsRequest;
use App\Imports\RowsExcelImport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UploadRowsController extends Controller
{

    public function create(): View
    {
        return view('rows.create');
    }

    public function store(UploadRowsRequest $request, RowsExcelImport $rowsExcelImport): RedirectResponse
    {
        try {
            $file = request()->file('excel-file');

            $fileName = sprintf(
                '%s-%s.%s',
                now()->format('H-i-s-u'),
                Str::random(7),
                $file->getClientOriginalExtension()
            );
            $path = now()->format('Y-m-d');
            $filePath = $file->storeAs($path, $fileName, 'excel-files');

            $rowsExcelImport->queue($filePath, 'excel-files');
        } catch (\Throwable $e) {
            Log::channel('excel-files')->error($e->getMessage());

            dd($e);

            return redirect()->back()->withErrors(['excel-file' => 'Can`t read file']);
        }

        return redirect()->back()->with(
            'success',
            sprintf('File %s successful uploaded', request()->file('excel-file')->getClientOriginalName())
        );
    }
}
