<?php


namespace PaLabs\EndpointBundle\Cache;


use PaLabs\EndpointBundle\Cache\EndpointRouteCacheWarmer;
use PaLabs\EndpointBundle\EndpointInterface;
use PaLabs\EndpointBundle\Loader\EndpointRouteLoaderCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EndpointRouteCacheWarmerCompilerPass implements CompilerPassInterface
{
    const SERVICE_NAME = 'pa_endpoint.cache_warmer';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::SERVICE_NAME)) {
            throw new \Exception("Route loader service is not registered");
        }

        $constructorArgs = [];
        foreach ($container->findTaggedServiceIds(EndpointRouteLoaderCompilerPass::TAG_NAME) as $id => $tags) {
            $constructorArgs[$id] = new Reference($id);
        }

        $routeLoader = $container->findDefinition(self::SERVICE_NAME);
        $routeLoader->setArgument(0, $constructorArgs);
    }
}