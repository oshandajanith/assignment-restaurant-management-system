<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        // Update order status to In-Progress
        $this->order->update([
            'status' => 'In-Progress',
            'queue_position' => $this->calculateQueuePosition()
        ]);
        
        // Additional processing logic
    }
    
    protected function calculateQueuePosition()
    {
        return Order::where('status', 'In-Progress')->count() + 1;
    }
}