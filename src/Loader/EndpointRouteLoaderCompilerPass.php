<?php


namespace PaLabs\EndpointBundle\Loader;


use PaLabs\EndpointBundle\EndpointInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EndpointRouteLoaderCompilerPass implements CompilerPassInterface
{
    const TAG_NAME = 'pa_labs.endpoint';
    const SERVICE_NAME = 'pa_endpoint.loader';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::SERVICE_NAME)) {
            throw new \Exception("Route loader service is not registered");
        }

        $constructorArgs = [];
        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $constructorArgs[$id] = new Reference($id);
        }

        $routeLoader = $container->findDefinition(self::SERVICE_NAME);
        $routeLoader->setArgument(0, $constructorArgs);
    }
}