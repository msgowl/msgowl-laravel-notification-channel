<?php

namespace MsgOwl\MsgowlLaravelNotificationChannel;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use MsgOwl\MsgowlLaravelNotificationChannel\Exceptions\InvalidConfiguration;

class MsgOwlServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->when(MsgOwlChannel::class)
            ->needs(MsgOwlClient::class)
            ->give(function () {
                $config = config('services.msgowl');

                if (is_null($config)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new MsgOwlClient(new Client, $config['api_key']);
            });
    }
}
