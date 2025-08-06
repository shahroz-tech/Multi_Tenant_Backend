<?php

namespace App\Actions\Stripe;

use Illuminate\Http\Request;

class CancelUserSubscriptionAction
{
    public function execute(Request $request): void
    {
        $request->user()->subscription('default')->cancel();
    }
}
