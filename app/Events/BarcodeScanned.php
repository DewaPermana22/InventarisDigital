<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BarcodeScanned implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public string $barcode;
    public int $userId;

    public function __construct(string $barcode, int $userId)
    {
        $this->barcode = $barcode;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('barcode-scan.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'barcode.scanned';
    }

    public function broadcastWith(): array
    {
        return [
            'barcode' => $this->barcode,
        ];
    }
}

