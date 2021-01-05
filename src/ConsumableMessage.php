<?php

namespace Alive2212\LaravelAmqp;

use PhpAmqpLib\Message\AMQPMessage;

abstract class ConsumableMessage
{
    private $stream, $properties, $exchange, $queue, $consumer, $deliveryInfo, $amqpMessage;

    public function __construct (string $stream = '', array $properties = []) {
        $this->stream = $stream;
        $this->properties = $properties;
    }

    /**
     * @param array $properties
     *
     * @return \Alive2212\LaravelAmqp\ConsumableMessage
     */
    public function setProperties (array $properties) : self {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties () : array {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function getStream () : string {
        return $this->stream;
    }

    /**
     * @param string $stream
     *
     * @return \Alive2212\LaravelAmqp\ConsumableMessage
     */
    public function setStream (string $stream) : self {
        $this->stream = $stream;

        return $this;
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

    /**
     * @return null|\Alive2212\LaravelAmqp\Queue
     */
    public function getQueue () : ?Queue {
        return $this->queue;
    }

    /**
     * @param \Alive2212\LaravelAmqp\Queue $queue
     *
     * @return self
     */
    public function setQueue ($queue) : self {
        $this->queue = $queue;

        return $this;
    }

    /**
     * @return \Alive2212\LaravelAmqp\AmqpConsumer|null
     */
    public function getConsumer () : ?AmqpConsumer {
        return $this->consumer;
    }

    /**
     * @param \Alive2212\LaravelAmqp\AmqpConsumer $consumer
     *
     * @return \Alive2212\LaravelAmqp\ConsumableMessage
     */
    public function setConsumer (AmqpConsumer $consumer) : self {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * @return \Alive2212\LaravelAmqp\Delivery|null
     */
    public function getDeliveryInfo () : ?Delivery {
        return $this->deliveryInfo;
    }

    /**
     * @param \Alive2212\LaravelAmqp\Delivery $deliveryInfo
     *
     * @return \Alive2212\LaravelAmqp\ConsumableMessage
     */
    public function setDeliveryInfo ($deliveryInfo) : self {
        $this->deliveryInfo = $deliveryInfo;

        return $this;
    }

    abstract public function handle ();

    /**
     * @return \PhpAmqpLib\Message\AMQPMessage|null
     */
    public function getAmqpMessage () : ?AMQPMessage {
        return $this->amqpMessage;
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $amqpMessage
     *
     * @return \Alive2212\LaravelAmqp\ConsumableMessage
     */
    public function setAmqpMessage (AMQPMessage $amqpMessage) : ConsumableMessage {
        $this->amqpMessage = $amqpMessage;

        return $this;
    }

    public function getMessageApplicationHeaders () : array {
        return ($amqp = $this->getAmqpMessage()) ? $amqp->get_properties()['application_headers']->getNativeData() : [];
    }

    public function getMessageApplicationHeader ($key, $default = null) {
        return array_key_exists($key, ($headers = $this->getMessageApplicationHeaders())) ? $headers[$key] : $default;
    }

    public function isRedelivered () : bool {
        return ($delivery = $this->getDeliveryInfo()) && ($info = $delivery->getProperties()) ? (bool) ($info['delivery_info']['redelivered'] ?? false) : false;
    }
}
