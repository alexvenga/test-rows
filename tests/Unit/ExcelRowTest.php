<?php

namespace Tests\Unit;

use App\Events\ExcelRowCreatedEvent;
use App\Models\ExcelRow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ExcelRowTest extends TestCase
{

    use RefreshDatabase;

    public function testDispatchEventOnCreateRow(): void
    {
        Event::fake([
            ExcelRowCreatedEvent::class,
        ]);

        ExcelRow::factory()->create(['id' => 7]);

        Event::assertDispatched(function (ExcelRowCreatedEvent $event) {
            return $event->excelRow->id === 7;
        });
    }
}
