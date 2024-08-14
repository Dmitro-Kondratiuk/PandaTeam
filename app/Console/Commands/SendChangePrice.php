<?php

namespace App\Console\Commands;

use App\Models\PriceTracking;
use Illuminate\Console\Command;

class SendChangePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
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
        $this->info('Start sending change price');

        $offset = 0;
        do {
            $price_tracking = PriceTracking::orderBy('id')
                ->limit(10)
                ->offset($offset)
                ->get();

            foreach ($price_tracking as $item) {
                if ($item->status == 'Pending') {
                    $subscriber_id = $item->subscriber_id;
                    foreach ($subscriber_id as $value) {
                        \App\Jobs\SendChangePrice::dispatch($value, $item);
                    }
                }
            }
        }
        while ($price_tracking->count() >= 10);

        $this->info('Finish sending change price');
    }
}
