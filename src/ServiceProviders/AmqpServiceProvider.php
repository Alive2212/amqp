<?php

namespace Alive2212\LaravelAmqp\ServiceProviders;

use Alive2212\LaravelAmqp\AmqpManager;
use Alive2212\LaravelAmqp\Consumer;
use Alive2212\LaravelAmqp\Publisher;
use Illuminate\Support\ServiceProvider;

class AmqpServiceProvider extends ServiceProvider
{
    public function register () {
        $this->app->bind('amqp', function ($app) {
            return app(AmqpManager::class);
        });

        /**
         * AmqpManager is made singleton so that the Class is destructed once
         * Which will make sure that the connections are also closed once through the following
         * - https://github.com/php-amqplib/php-amqplib/blob/v2.9.2/PhpAmqpLib/Connection/AbstractConnection.php#L289
         */
        $this->app->singleton(AmqpManager::class, function ($app) {
            return new AmqpManager($app);
        });

        $this->app->bind(Publisher::class, function () {
            return new Publisher();
        });

        $this->app->bind(Consumer::class, function () {
            return new Consumer();
        });

        if (!str_contains($this->app->version(), 'Lumen')) {
            $this->publishes([
                __DIR__ . '/../config/amqp.php' => config_path('amqp.php'),
            ]);
        }
    }

    public function provides () {
        return [ 'amqp', AmqpManager::class, Publisher::class, Consumer::class ];
    }
}
