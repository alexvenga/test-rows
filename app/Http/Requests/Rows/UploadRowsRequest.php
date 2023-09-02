<?php

namespace App\Http\Requests\Rows;

use Illuminate\Foundation\Http\FormRequest;

class UploadRowsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'excel-file' => 'file',
        ];
    }

    public function rules(): array
    {
        return [
            'excel-file' => [
                'bail',
                'required',
                'file',
                'max:10240',
            ]
        ];
    }
}
