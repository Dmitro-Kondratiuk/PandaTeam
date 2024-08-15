<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Jobs\CreatePriceTracking;
use App\Models\SubscriptionOnItem;


class SubscriptionController extends Controller
{
    public function index() {
        return view('subscription.index');
    }

    public function createSubscription(SubscriptionRequest $request) {

        $data = $request->all();
        $userItem = SubscriptionOnItem::where(['url' => $data['url'], 'email' => $data['email']])->first();
        if ($userItem) {
            $message = 'You have already subscribed to update this product';

            return redirect()->route('index')->with('message', $message);
        }

        $userId                = auth()->user()->getAuthIdentifier();

        $subscription          = new SubscriptionOnItem();
        $subscription->url     = htmlspecialchars($data['url']);
        $subscription->email   = htmlspecialchars($data['email']);
        $subscription->user_id = $userId;
        $subscription->save();


        CreatePriceTracking::dispatch($userId, $data['url']);

        return redirect()->route('index')->with('success', 'Success');
    }
}
