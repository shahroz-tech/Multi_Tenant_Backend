<?php

namespace App\Actions\Stripe;

use Illuminate\Support\Facades\Log;

class HandleCustomerUpdatedAction
{
    public function execute($customer): void
    {
        Log::info("👤 Customer updated: ID {$customer->id}");
    }
}
