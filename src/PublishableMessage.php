<?php

namespace Alive2212\LaravelAmqp;

use PhpAmqpLib\Message\AMQPMessage;

class PublishableMessage
{
    private $stream, $properties, $exchange;

    public function __construct (string $stream, array $properties = []) {
        $this->stream = $stream;
        $this->properties = $properties;
    }

    /**
     * @param array $properties
     *
     * @return \Alive2212\LaravelAmqp\PublishableMessage
     */
    public function setProperties (array $properties) : self {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return \PhpAmqpLib\Message\AMQPMessage
     */
    public function getAmqpMessage () : AMQPMessage {
        return new AMQPMessage($this->stream, $this->properties ?: []);
    }

    /**
     * @return string
     */
    public function getStream () : string {
        return $this->stream;
    }

    /**
     * @return array
     */
    public function getProperties () : array {
        return $this->properties;
    }

    /**
     * @return null|\Alive2212\LaravelAmqp\Exchange
     */
    public function getExchange () : ?Exchange {
        return $this->exchange;
    }

    /**
     * @param \Alive2212\LaravelAmqp\Exchange $exchange
     *
     * @return self
     */
    public function setExchange ($exchange) : self {
        $this->exchange = $exchange;

        return $this;
    }

}
