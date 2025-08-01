<?php

namespace App\Http\Controllers\Api\V1\Stripe;

use App\Actions\Stripe\CancelUserSubscriptionAction;
use App\Actions\Stripe\ResumeUserSubscriptionAction;
use App\Actions\Stripe\ShowUserSubscriptionAction;
use App\Actions\Stripe\SubscribeUserToPlanAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function subscribe(Request $request, SubscribeUserToPlanAction $subscribeAction)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $subscription = $subscribeAction->execute($request);

        return response()->json([
            'message' => 'Subscribed successfully',
            'subscription' => $subscription,
        ]);
    }

    public function show(Request $request, ShowUserSubscriptionAction $showAction)
    {
        return response()->json($showAction->execute($request));
    }

    public function cancel(Request $request, CancelUserSubscriptionAction $cancelAction)
    {
        $cancelAction->execute($request);
        return response()->json(['message' => 'Subscription canceled']);
    }

    public function resume(Request $request, ResumeUserSubscriptionAction $resumeAction)
    {
        $resumeAction->execute($request);
        return response()->json(['message' => 'Subscription resumed']);
    }
}
