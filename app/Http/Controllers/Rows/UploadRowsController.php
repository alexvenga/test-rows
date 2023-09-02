<?php

namespace App\Http\Controllers\Rows;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rows\UploadRowsRequest;
use App\Imports\RowsExcelImport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UploadRowsController extends Controller
{

    public function create(): View
    {
        return view('rows.create');
    }

    public function store(UploadRowsRequest $request, RowsExcelImport $rowsExcelImport): RedirectResponse
    {
        try {
            $fileName = $this->storeFile($request->file('excel-file'));
            $rowsExcelImport->queue($fileName, config('services.excel-files.disk'));
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return redirect()->back()->withErrors(['excel-file' => 'Can`t read Excel file']);
        } catch (\Throwable $e) {
            dd($e);

            Log::channel('excel-files')->error($e->getMessage());

            return redirect()->back()->withErrors(['excel-file' => 'Unknown error']);
        }

        return redirect()->back()->with(
            'success',
            sprintf('File %s successful uploaded', request()->file('excel-file')->getClientOriginalName())
        );
    }

    protected function storeFile(UploadedFile $file): string
    {
        $fileName = sprintf(
            '%s-%s.%s',
            now()->format('H-i-s-u'),
            Str::random(7),
            $file->getClientOriginalExtension()
        );
        $path = now()->format('Y-m-d');

        return $file->storeAs($path, $fileName, config('services.excel-files.disk'));
    }
}
