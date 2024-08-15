<?php

namespace Tests\Unit;

use App\Mail\AlertsMail;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class SubscriptionServiceTest extends TestCase
{

    public function testGetPrice() {
        $service = new SubscriptionService();
        $price = $service->getPrice('https://www.olx.ua/d/obyavlenie/prodam-audi-a6s6-IDWXO3V.html');

        $this->assertEquals('100 $', $price);
    }
    public function testSendMail()
    {
        $mockedSubscription = Mockery::mock(\App\Models\SubscriptionOnItem::class);

        $mockedSubscription->shouldReceive('where')
            ->with(['user_id' => 9, 'url' => 'https://www.olx.ua/d/obyavlenie/prodam-uaz-469-b-na-hodu-IDWXkKR.html'])
            ->andReturnSelf();
        $mockedSubscription->shouldReceive('first')
            ->andReturn((object) ['email' => 'kondratyuk.mitya@gmail.com']);

        Mail::fake();

        $service = new SubscriptionService();
        $mockedPriceTracking = (object) ['price' => '100 $', 'url' => 'https://www.olx.ua/d/obyavlenie/prodam-uaz-469-b-na-hodu-IDWXkKR.html'];
        $service->sendMail(9, $mockedPriceTracking);

        Mail::assertSent(AlertsMail::class, function ($mail) {
            return $mail->hasTo('kondratyuk.mitya@gmail.com');
        });
    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
