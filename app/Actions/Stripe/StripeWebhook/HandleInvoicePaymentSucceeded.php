<?php
namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleInvoicePaymentSucceededAction
{
    public function execute($invoice): void
    {
        Log::info("🟢 Payment succeeded: " . json_encode($invoice));
    }
}
