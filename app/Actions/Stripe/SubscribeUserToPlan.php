<?php

namespace App\Actions\Stripe;

use Illuminate\Http\Request;

class SubscribeUserToPlanAction
{
    public function execute(Request $request)
    {
        $user = $request->user();

        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($request->payment_method);

        return $user->newSubscription('default', config('services.stripe.plan'))
            ->create($request->payment_method);
    }
}
