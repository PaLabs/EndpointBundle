<?php


namespace PaLabs\EndpointBundle\Loader;


use PaLabs\EndpointBundle\EndpointInterface;
use PaLabs\EndpointBundle\EndpointRoute;
use PaLabs\EndpointBundle\EndpointRouteCollection;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class EndpointRouteLoader extends Loader
{
    private array $endpoints;

    public function __construct(array $endpoints = [])
    {
        parent::__construct();
        $this->endpoints = $endpoints;
    }

    public function load($resource, $type = null): RouteCollection
    {
        $collection = new RouteCollection();
        foreach ($this->endpoints as $serviceId => $endpoint) {
            /** @var  EndpointInterface $endpoint */
            $routes = self::normalizeRoutes($endpoint);

            /** @var EndpointRoute $endpointRoute */
            foreach ($routes as $endpointRoute) {
                $routeName = $endpointRoute->getRouteName();
                $defaults = [
                    '_controller' => $serviceId
                ];

                $route = $endpointRoute->getRoute();
                $route->addDefaults($defaults);
                $collection->add($routeName, $route);
            }
        }

        return $collection;
    }

    public static function normalizeRoutes(EndpointInterface $endpoint): EndpointRouteCollection
    {
        $routes = $endpoint->routes();

        if ($routes instanceof Route) {
            return new EndpointRouteCollection(new EndpointRoute(get_class($endpoint), $routes));
        } elseif ($routes instanceof EndpointRoute) {
            return new EndpointRouteCollection($routes);
        } elseif ($routes instanceof EndpointRouteCollection) {
            return $routes;
        } else {
            throw new \Exception(sprintf("Invalid return value of routes() method of %s", get_class($endpoint)));
        }
    }


    public function supports($resource, $type = null): bool
    {
        return 'endpoints' == $type;
    }


}