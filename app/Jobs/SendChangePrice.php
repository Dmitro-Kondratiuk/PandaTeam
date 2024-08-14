<?php

namespace App\Jobs;

use App\Services\SubscriptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendChangePrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int    $id;
    private string $price;
    private object $priceTracking;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id, object $priceTracking) {
        $this->id            = $id;
        $this->priceTracking = $priceTracking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        (new SubscriptionService())->sendMail($this->id, $this->priceTracking);
    }
}
