<?php
namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleSubscriptionCreatedAction
{
    public function execute($subscription): void
    {
        Log::info("✅ New subscription created: ID {$subscription->id}, Customer {$subscription->customer}");
    }
}
