<?php
namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleInvoicePaymentFailedAction
{
    public function execute($data): void
    {
        Log::warning("❌ Payment failed: " . json_encode($data));
    }
}
