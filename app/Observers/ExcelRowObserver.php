<?php

namespace App\Observers;

use App\Events\ExcelRowCreatedEvent;
use App\Models\ExcelRow;

class ExcelRowObserver
{

    public function created(ExcelRow $excelRow): void
    {
        ExcelRowCreatedEvent::dispatch($excelRow);
    }

}
