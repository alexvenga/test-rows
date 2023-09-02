<?php

namespace App\Http\Controllers\Rows;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rows\UploadRowsRequest;
use Illuminate\Contracts\View\View;

class UploadRowsController extends Controller
{

    public function create(): View
    {
        return view('rows.create');
    }

    public function store(UploadRowsRequest $request)
    {

        dd($request->file('excel-file')->getRealPath());

    }
}
