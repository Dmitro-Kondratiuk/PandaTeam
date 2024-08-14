<?php

namespace App\Jobs;

use App\Services\SubscriptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePriceTracking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int    $id;
    private string $url;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id, string $url) {
        $this->id  = $id;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $newService = new SubscriptionService();
        $price = $newService->getPrice($this->url);
        $newService->createPriceTracking($this->url,$this->id,$price);
    }
}
