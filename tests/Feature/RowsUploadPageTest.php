<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
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

        $preparation = new UploadedFile(
            public_path('test.xlsx'),
            'test.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this
            ->post('/rows', [
                'excel-file' => $preparation
            ]);

        $response->assertRedirect();

        $response->assertSessionHas('success');

    }

}