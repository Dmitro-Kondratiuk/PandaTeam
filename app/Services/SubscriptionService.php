<?php

namespace App\Services;

use App\Mail\AlertsMail;
use App\Models\PriceTracking;
use App\Models\SubscriptionOnItem;
use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use Illuminate\Support\Facades\Mail;

class SubscriptionService
{
    public function getPrice(string $adUrl): string {
        $host    = env('SELENIUM');
        $options = new ChromeOptions();
        $options->addArguments([
            '--headless',
            '--no-sandbox',
            '--disable-dev-shm-usage',
        ]);
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $price = '';
        try {
            $driver = RemoteWebDriver::create($host, $capabilities);

            $driver->get($adUrl);

            $wait    = new WebDriverWait($driver);
            $element = $wait->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::className('css-90xrc0'))
            );
            $price   = $element->getText();
        }
        catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $price;
    }


    public function createPriceTracking($url, $userId, $price): void {
        $price_trackingItem = PriceTracking::where(['url' => $url])->first();
        if ($price_trackingItem) {
            $subscriber_ids = $price_trackingItem->subscriber_id;

            if (!in_array($userId, $subscriber_ids)) {
                $subscriber_ids[] = $userId;
            }

            $price_trackingItem->subscriber_id = $subscriber_ids;
            $price_trackingItem->save();
        }
        else {
            $price_tracking                = new PriceTracking();
            $price_tracking->url           = $url;
            $price_tracking->subscriber_id = [$userId];
            $price_tracking->price         = $price;
            $price_tracking->status        = 'Sent';
            $price_tracking->save();
        }
    }

    public function sendMail($id, $priceTracking): void {
        $subscriptionOnItem = SubscriptionOnItem::where([
            'user_id' => $id,
            'url'     => $priceTracking->url,
        ])->first();
        $data               = [
            'price' => $priceTracking->price,
            'url'   => $priceTracking->url,
        ];

        Mail::to($subscriptionOnItem->email)->send(new AlertsMail($data));

        if ($priceTracking instanceof PriceTracking) {
            $priceTracking->status     = 'Sent';
            $priceTracking->updated_at = now();
            $priceTracking->save();
        }
    }
}
