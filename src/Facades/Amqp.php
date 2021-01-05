<?php

namespace Alive2212\LaravelAmqp\Facades;

use Illuminate\Support\Facades\Facade;

class Amqp extends Facade
{
    protected static function getFacadeAccessor () {
        return 'amqp';
    }
}
