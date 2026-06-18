<?php

namespace App\Providers;

use App\Models\cart_item;
use App\Notification\SmsNotification;
use App\NotificationInterface;
use App\PaymentInterface;
use App\Payments\StripeService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // $this->app->bind(\App\PaymentInterface::class, \App\Payments\PaypalService::class);
        $this->app->bind(PaymentInterface::class , StripeService::class);
        $this->app->bind(NotificationInterface::class , SmsNotification::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Paginator::useBootstrapFive();
        // URL::forceScheme('https');

        View::composer('*', function ($view) {

        if (Auth::user()) {
            $count = cart_item::where('user_id',Auth::user()->id)->count();
        } else {
            $count = 0;
        }

        $view->with('cartCount', $count);
    });

    }
}
