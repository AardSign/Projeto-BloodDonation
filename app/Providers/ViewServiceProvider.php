<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('admin.navbar', function ($view) {
            if (Auth::check()) {
                $view->with('notificacoes', Notification::where('user_id', Auth::id())
                    ->latest()
                    ->take(10)
                    ->get());
            }
        });
    }
}
