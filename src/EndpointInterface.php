<?php


namespace PaLabs\EndpointBundle;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;

interface EndpointInterface
{
    /**
     * Returns list of routes for current endpoint
     * @return Route|EndpointRoute|EndpointRouteCollection
     */
    public function routes();

    public function __invoke(Request $request): Response;
}