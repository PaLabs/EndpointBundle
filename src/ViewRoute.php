<?php

namespace PaLabs\EndpointBundle;


class ViewRoute
{
    public $name;
    public $parameters;

    public function __construct($name, array $parameters = []) {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    public function merge(array $parameters) {
        return new ViewRoute($this->name, array_merge($this->parameters, $parameters));
    }
}