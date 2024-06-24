<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $data = Notification::where('role', auth()->user()->role)->get();

            $view->with('notificationData', $data);
        });
    }
}
