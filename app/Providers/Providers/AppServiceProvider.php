<?php

namespace App\Providers\Providers;

use App\Events\CommentAddedEvent;
use App\Events\ProjectUpdatedEvent;
use App\Events\TaskAssignedEvent;
use App\Listeners\CommentAddedListener;
use App\Listeners\ProjectUpdatedListener;
use App\Listeners\TaskAssignedListener;
use App\Policies\TeamPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('user-tier', function (Request $request) {
            $user = $request->user();

            // If user is not subscribed, limit to 1000 per day
            if (!$user->is_subscribed) {
                return Limit::perDay(1000)->by($user->id);
            }

            // If user is subscribed, allow unlimited requests
            return Limit::none();
        });
    }

}
