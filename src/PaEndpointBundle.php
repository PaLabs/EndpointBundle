<?php


namespace PaLabs\EndpointBundle;


use PaLabs\EndpointBundle\DependencyInjection\PaEndpointExtension;
use PaLabs\EndpointBundle\Loader\EndpointRouteLoaderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PaEndpointBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new PaEndpointExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new EndpointRouteLoaderCompilerPass())
            ->addCompilerPass(new EndpointServicePublicMakerCompilerPass());
    }
}