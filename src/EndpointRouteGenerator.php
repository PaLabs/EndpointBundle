<?php


namespace PaLabs\EndpointBundle;


use Symfony\Component\Routing\RouterInterface;

class EndpointRouteGenerator
{
    private $router;
    private $endpointRoutes = [];

    public function __construct(
        RouterInterface $router,
        string $cacheDir)
    {
        $this->router = $router;
        $routesCacheFile = $cacheDir . '/endpointRoutes.php';
        if (file_exists($routesCacheFile)) {
            $this->endpointRoutes = include $routesCacheFile;
        }

    }

    public function routeId(string $endpointClass)
    {
        if (!isset($this->endpointRoutes[$endpointClass])) {
            throw new \Exception(sprintf("Endpoint does not exist, %s", $endpointClass));
        }
        $routes = $this->endpointRoutes[$endpointClass];
        switch (count($routes)) {
            case 0:
                throw new \Exception(sprintf("Endpoint has no routes, %s", $endpointClass));
            case 1:
                return $routes[0];
            default:
                throw new \Exception(sprintf("Endpoint has multiple routes, you need use standart route, %s", $endpointClass));
        }
    }

    public function route($endpointClass, array $parameters = [])
    {
        $routeId = $this->routeId($endpointClass);
        return new ViewRoute($routeId, $parameters);
    }

    public function url($endpointClass, array $parameters = [])
    {
        $route = $this->route($endpointClass, $parameters);
        return $this->router->generate($route->name, $route->parameters);
    }
}