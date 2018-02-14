<?php


namespace PaLabs\EndpointBundle;


use PaLabs\EndpointBundle\Cache\EndpointRouteCacheWarmer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class EndpointRouter
{

    private $router;
    private $endpointRoutes = [];

    public function __construct(
        RouterInterface $router,
        string $cacheDir)
    {
        $this->router = $router;
        $routesCacheFile = $cacheDir . DIRECTORY_SEPARATOR . EndpointRouteCacheWarmer::CACHE_FILE_NAME;
        if (file_exists($routesCacheFile)) {
            $this->endpointRoutes = include $routesCacheFile;
        }

    }

    public function route(string $endpointClass, array $parameters = []): ViewRoute
    {
        $routeId = $this->routeId($endpointClass);
        return new ViewRoute($routeId, $parameters);
    }

    public function url(string $endpointClass, array $parameters = [], int  $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        $route = $this->route($endpointClass, $parameters);
        return $this->router->generate($route->getName(), $route->getParameters(), $referenceType);
    }

    protected function routeId(string $endpointClass): string
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
}