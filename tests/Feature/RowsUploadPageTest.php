<?php

namespace Tests\Feature;

use App\Imports\RowsExcelImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class RowsUploadPageTest extends TestCase
{

    public function testRowsUploadPageStatus(): void
    {
        $response = $this->get('/rows/create');

        $response->assertOk();
    }

    public function testUploadNonExcelFile(): void
    {

        $response = $this
            ->post('/rows', [
                'excel-file' => UploadedFile::fake()->create('test.xlsx')
            ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('excel-file');
    }

    public function testUploadExcelFile(): void
    {

        Excel::fake();

        $preparation = new UploadedFile(
            base_path('/tests/resources/test.xlsx'),
            'test.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this
            ->post('/rows', [
                'excel-file' => $preparation
            ]);

        Excel::assertQueued('test.xlsx', config('services.excel-resources.disk'), fn(RowsExcelImport $rowsExcelImport) => true);

        $response->assertRedirect();

        $response->assertSessionHas('success');

    }

}
