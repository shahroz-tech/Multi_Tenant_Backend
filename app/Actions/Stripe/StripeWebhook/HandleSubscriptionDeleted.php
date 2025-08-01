<?php

namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleSubscriptionDeletedAction
{
    public function execute($subscription): void
    {
        Log::warning("🗑️ Subscription deleted: ID {$subscription->id}");
    }
}
