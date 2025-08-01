<?php

namespace App\Http\Controllers\Api\V1\Stripe;

use App\Actions\Stripe\HandleChargeSucceededAction;
use App\Actions\Stripe\HandleCustomerUpdatedAction;
use App\Actions\Stripe\HandleInvoicePaymentFailedAction;
use App\Actions\Stripe\HandleInvoicePaymentSucceededAction;
use App\Actions\Stripe\HandleSubscriptionCreatedAction;
use App\Actions\Stripe\HandleSubscriptionDeletedAction;
use App\Actions\Stripe\HandleSubscriptionUpdatedAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(
        Request                             $request,
        HandleInvoicePaymentSucceededAction $paymentSucceeded,
        HandleInvoicePaymentFailedAction    $paymentFailed,
        HandleSubscriptionCreatedAction     $subscriptionCreated,
        HandleSubscriptionUpdatedAction     $subscriptionUpdated,
        HandleSubscriptionDeletedAction     $subscriptionDeleted,
        HandleCustomerUpdatedAction         $customerUpdated,
        HandleChargeSucceededAction         $chargeSucceeded
    )
    {
        Log::info('📩 Stripe webhook received');

        $endpoint_secret = config('services.stripe.webhook_secret'); // safer: move secret to config
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('❗ Invalid Stripe payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('❗ Invalid Stripe signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        match ($event->type) {
            'invoice.payment_succeeded' => $paymentSucceeded->execute($event->data->object),
            'invoice.payment_failed' => $paymentFailed->execute($event->data->object),
            'customer.subscription.created' => $subscriptionCreated->execute($event->data->object),
            'customer.subscription.updated' => $subscriptionUpdated->execute($event->data->object),
            'customer.subscription.deleted' => $subscriptionDeleted->execute($event->data->object),
            'customer.updated' => $customerUpdated->execute($event->data->object),
            'charge.succeeded' => $chargeSucceeded->execute($event->data->object),
            default => Log::info("📌 Unhandled event type: " . $event->type),
        };

        return response()->json(['status' => 'ok']);
    }
}
