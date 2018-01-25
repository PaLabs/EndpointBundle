<?php


namespace PaLabs\EndpointBundle\Loader;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EndpointRouteLoaderCompilerPass implements CompilerPassInterface
{
    const TAG_NAME = 'pa_labs.endpoint';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(EndpointRouteLoader::class)) {
            throw new \Exception("Route loader service is not registered");
        }

        $constructorArgs = [];
        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $constructorArgs[$id] = new Reference($id);
        }

        $routeLoader = $container->findDefinition(EndpointRouteLoader::class);
        $routeLoader->setArgument(0, $constructorArgs);
    }
}