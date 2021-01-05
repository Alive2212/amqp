<?php

namespace Alive2212\LaravelAmqp;

use Closure;

class GenericConsumableMessage extends ConsumableMessage
{
    private $handler;

    public function __construct (Closure $handler) {
        parent::__construct();
        $this->handler = $handler;
    }

    public function handle () {
        $this->handler->call($this, $this);
    }
}
