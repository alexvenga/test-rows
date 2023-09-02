<?php

namespace App\Events;

use App\Models\ExcelRow;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExcelRowCreatedEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public ExcelRow $excelRow)
    {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('excel-rows'),
        ];
    }
}
