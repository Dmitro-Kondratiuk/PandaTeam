<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Jobs\CreatePriceTracking;
use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;


class SubscriptionController extends Controller
{
    public function index() {
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

            $driver->get('https://www.olx.ua/d/obyavlenie/lincoln-mkx-reserve-IDRG0LM.html');

            $wait    = new WebDriverWait($driver);
            $element = $wait->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::className('css-90xrc0'))
            );
            $price   = $element->getText();
            dd($price);
        }
        catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage();
        }
        return view('subscription.index');
    }

    public function createSubscription(SubscriptionRequest $request) {

        $data = $request->all();

        $userItem = User::where(['url' => $data['url'], 'email' => $data['email']])->first();
        if ($userItem) {
            $message = 'You have already subscribed to update this product';

            return redirect()->route('index')->with('message', $message);
        }
        $user        = new User();
        $user->email = $data['email'];
        $user->url   = $data['url'];
        $user->save();

        $userId = $user->id;
        CreatePriceTracking::dispatch($userId, $data['url']);

        return redirect()->route('index')->with('success', 'Success');
    }
}
