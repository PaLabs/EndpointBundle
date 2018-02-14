<?php


namespace PaLabs\EndpointBundle\Cache;


use PaLabs\EndpointBundle\EndpointInterface;
use PaLabs\EndpointBundle\Loader\EndpointRouteLoader;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class EndpointRouteCacheWarmer implements CacheWarmerInterface
{
    const CACHE_FILE_NAME = 'endpointRoutes.php';

    private $endpoints = [];

    public function __construct(array $endpoints = [])
    {
        $this->endpoints = $endpoints;
    }

    public function isOptional()
    {
        return false;
    }

    public function warmUp($cacheDir)
    {
        $endpointRouteNames = [];

        foreach ($this->endpoints as $serviceId => $endpoint) {
            /** @var  EndpointInterface $endpoint */
            $routes = EndpointRouteLoader::normalizeRoutes($endpoint);
            $endpointClass = get_class($endpoint);

            foreach ($routes as $endpointRoute) {
                $routeName = $endpointRoute->getRouteName();
                $endpointRouteNames[$endpointClass][] = $routeName;
            }
        }

        $this->dump($endpointRouteNames, $cacheDir . DIRECTORY_SEPARATOR . self::CACHE_FILE_NAME);
    }

    private function dump(array $data, string $cachePath)
    {
        $code = sprintf("<?php
            return %s
        ;
        ", var_export($data, true));

        $fs = new Filesystem();
        $fs->dumpFile($cachePath, $code);
    }
}