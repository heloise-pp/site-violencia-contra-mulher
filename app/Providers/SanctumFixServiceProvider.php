<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class SanctumFixServiceProvider extends ServiceProvider
{
    public function boot()
    {

        app('router')->aliasMiddleware('sanctum', EnsureFrontendRequestsAreStateful::class);

        EnsureFrontendRequestsAreStateful::setExcludedDomains(['*']);
    }
}
