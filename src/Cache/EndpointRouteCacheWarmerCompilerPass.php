<?php


namespace PaLabs\EndpointBundle\Cache;


use PaLabs\EndpointBundle\Loader\EndpointRouteLoaderCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EndpointRouteCacheWarmerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(EndpointRouteCacheWarmer::class)) {
            throw new \Exception("Route loader service is not registered");
        }

        $constructorArgs = [];
        foreach ($container->findTaggedServiceIds(EndpointRouteLoaderCompilerPass::TAG_NAME) as $id => $tags) {
            $constructorArgs[$id] = new Reference($id);
        }

        $routeLoader = $container->findDefinition(EndpointRouteCacheWarmer::class);
        $routeLoader->setArgument(0, $constructorArgs);
    }
}