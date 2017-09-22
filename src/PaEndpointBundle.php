<?php


namespace PaLabs\EndpointBundle;


use PaEndpointExtension;
use PaLabs\EndpointBundle\Cache\EndpointRouteCacheWarmerCompilerPass;
use PaLabs\EndpointBundle\Loader\EndpointRouteLoaderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PaEndpointBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new PaEndpointExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new EndpointRouteLoaderCompilerPass())
            ->addCompilerPass(new EndpointRouteCacheWarmerCompilerPass());
    }
}