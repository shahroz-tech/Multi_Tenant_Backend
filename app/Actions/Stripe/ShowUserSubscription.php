<?php

namespace App\Actions\Stripe;

use Illuminate\Http\Request;

class ShowUserSubscriptionAction
{
    public function execute(Request $request): array
    {
        $subscription = $request->user()->subscription('default');

        return [
            'subscription' => $subscription,
            'is_active' => $subscription && $subscription->active(),
        ];
    }
}
