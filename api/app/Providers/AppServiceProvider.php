<?php

namespace App\Providers;

use App\Connections\Faceit;
use App\Models\Hub;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'hub' => Hub::class,
        ]);

        app()->singleton('faceit', function () {
            return new Faceit([
                'key' => config('services.faceit.api_key'),
            ]);
        });

        app()->singleton('faceit.private', function () {
            return new Faceit([
                'use_private_api' => true,
                'key' => config('services.faceit.private.api_key'),
                'user_id' => config('services.faceit.private.user_id'),
            ]);
        });
    }
}
