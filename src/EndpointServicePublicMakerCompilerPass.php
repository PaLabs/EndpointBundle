<?php


namespace PaLabs\EndpointBundle;


use PaLabs\EndpointBundle\Loader\EndpointRouteLoaderCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EndpointServicePublicMakerCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds(EndpointRouteLoaderCompilerPass::TAG_NAME , true) as $id => $tags) {
            $def = $container->getDefinition($id);
            $def->setPublic(true);
        }
    }
}