<?php


namespace PaLabs\EndpointBundle;


use Symfony\Component\Routing\Route;

class EndpointRoute
{
    protected string $routeName;
    protected Route $route;

    public function __construct(string $routeName, Route $route) {
        if(empty($routeName)) {
            throw new \Exception('Route name must be not empty');
        }
        $this->routeName = $routeName;
        $this->route = $route;
    }

    public function getRouteName(): string
    {
        return $this->routeName;
    }

     public function getRoute(): Route
    {
        return $this->route;
    }


}