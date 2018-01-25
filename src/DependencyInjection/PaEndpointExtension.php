<?php

namespace PaLabs\EndpointBundle\DependencyInjection;

use PaLabs\EndpointBundle\EndpointInterface;
use PaLabs\EndpointBundle\Loader\EndpointRouteLoaderCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class PaEndpointExtension  extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(EndpointInterface::class)
            ->addTag(EndpointRouteLoaderCompilerPass::TAG_NAME);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}