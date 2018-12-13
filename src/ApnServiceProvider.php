<?php

namespace SemyonChetvertnyh\ApnNotificationChannel;

use Pushok\Client;
use Pushok\AuthProvider\Token;
use Illuminate\Support\ServiceProvider;

class ApnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->bind(Client::class, function ($app) {
            $config = $app['config']->get('broadcasting.connections.apn');

            $authProvider = Token::create([
                'key_id' => $config['key_id'],
                'team_id' => $config['team_id'],
                'app_bundle_id' => $config['app_bundle_id'],
                'private_key_path' => $config['private_key_path'],
                'private_key_secret' => $config['private_key_secret'],
            ]);

            return new Client($authProvider, $config['is_production']);
        });
    }
}
