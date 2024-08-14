<?php

namespace App\Console\Commands;

use App\Models\PriceTracking;
use App\Services\SubscriptionService;
use Illuminate\Console\Command;

class CheckChangePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-change-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void {

        $offset  = 0;
        $service = new SubscriptionService();
        do {
            $price_tracking = PriceTracking::orderBy('id')
                ->limit(10)
                ->offset($offset)
                ->get();
            foreach ($price_tracking as $item) {
                $price = $service->getPrice($item->url);
                if ($price !== $item->price) {
                    $item->price  = $price;
                    $item->status = 'Pending';
                    $item->save();
                }
            }
            $offset = $offset + 10;
        }
        while ($price_tracking->count() >= 10);
    }
}
