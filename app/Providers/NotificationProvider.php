<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
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
            $authRoutes = [
                'login',
                'post-login',
                'logout'
            ];

            if (!in_array(request()->route()->getName(), $authRoutes)) {
                $data = Notification::where('role', auth()->user()->role)
                    ->whereDate('created_at', '>=', now()->subDays(3))
                    ->where('is_read', false)
                    ->get();
                $view->with('notificationData', $data);
            }
        });
    }
}
