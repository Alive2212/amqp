<?php

namespace Alive2212\LaravelAmqp;

class Exchange
{
    private $name, $properties;

    public function __construct (string $name, array $properties = []) {
        $this->setName($name);
        $this->setProperties($properties);
    }

    /**
     * @return string
     */
    public function getName () : string {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Alive2212\LaravelAmqp\Exchange
     */
    public function setName (string $name) : self {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties () : array {
        return $this->properties;
    }

    /**
     * @param array $properties
     *
     * @return \Alive2212\LaravelAmqp\Exchange
     */
    public function setProperties (array $properties) : self {
        $this->properties = $properties;

        return $this;
    }
}
