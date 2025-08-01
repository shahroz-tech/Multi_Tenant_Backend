<?php
namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleChargeSucceededAction
{
    public function execute($charge): void
    {
        Log::info("💳 Charge succeeded: ID {$charge->id}");
    }
}
