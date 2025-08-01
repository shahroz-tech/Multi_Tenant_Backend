<?php

namespace App\Actions\Stripe;

use Illuminate\Http\Request;

class ResumeUserSubscriptionAction
{
    public function execute(Request $request): void
    {
        $request->user()->subscription('default')->resume();
    }
}
