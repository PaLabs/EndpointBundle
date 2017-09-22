<?php


namespace PaLabs\EndpointBundle;


use ArrayIterator;
use IteratorAggregate;

class EndpointRouteCollection implements IteratorAggregate
{

    private $routes;

    public function __construct(EndpointRoute... $routes)
    {
        $this->routes = $routes;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }
}