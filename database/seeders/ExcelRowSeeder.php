<?php

namespace Database\Seeders;

use App\Models\ExcelRow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExcelRowSeeder extends Seeder
{

    use WithoutModelEvents;

    public function run(): void
    {
        ExcelRow::factory(1000)->create();
    }
}
