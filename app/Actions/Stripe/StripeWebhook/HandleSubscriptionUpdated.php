<?php
namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleSubscriptionUpdatedAction
{
    public function execute($subscription): void
    {
        if ($subscription->cancel_at_period_end) {
            Log::warning("⛔ Subscription cancel scheduled at period end: ID {$subscription->id}");
        } elseif ($subscription->canceled_at) {
            Log::warning("❌ Subscription canceled immediately: ID {$subscription->id}");
        } elseif (!$subscription->cancel_at && !$subscription->canceled_at) {
            Log::info("🔁 Subscription resumed: ID {$subscription->id}");
        } else {
            Log::info("📦 Subscription updated: ID {$subscription->id}");
        }
    }
}
