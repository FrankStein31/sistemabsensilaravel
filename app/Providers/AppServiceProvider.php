<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Providers\StudentAuthProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Auth::provider('students', function ($app, array $config) {
            return new StudentAuthProvider($app['hash'], $config['model']);
        });
    }
}
