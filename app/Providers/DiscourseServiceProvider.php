<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class DiscourseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('discourse-client', function ($app) {
            return new Client([
                'base_uri' => config('discourse-api.base_url'),
                'headers' => [
                    'Api-Key' => config('discourse-api.api_key'),
                    'Api-Username' => config('discourse-api.api_username'),
                ],
                'http_errors' => false,
            ]);
        });
    }
}
