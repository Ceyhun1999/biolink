<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void {}

    public function boot(): void
    {
        View::composer('admin.layouts.default', function ($view) {
            $settings = Setting::first();
            $view->with('settings', $settings);
        });
    }
}
