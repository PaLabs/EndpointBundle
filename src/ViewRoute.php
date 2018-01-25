<?php

namespace PaLabs\EndpointBundle;


class ViewRoute
{
    protected $name;
    protected $parameters;

    public function __construct(string $name, array $parameters = []) {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    public function merge(array $parameters) {
        return new ViewRoute($this->name, array_merge($this->parameters, $parameters));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }


}