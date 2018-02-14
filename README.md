PaEndpointBundle
=================

PaEndpointBundle add alternative to symfony controllers. 
Endpoint is a controller with only one method - **execute(Request): Response**

Features include:

- Simple and clean endpoint interface - only one request handler in one class
- Easy way to generate routes, e.g. $router->url(SomeEndpoint::class)
- Refactorable - no additional changes need if you move or rename endpoint
- No route names need (but if you want you can specify it in route definition)
- Supports for extending endpoints - you can define base endpoints and many childs with shared routes configuration. It's is very common task in crud controllers.

Installation
-------------
Add bundle to you composer.json: 
```bash
composer require palabs/endpoint-bundle
```

Register bundle in Kernel:
```php
// app/AppKernel.php

public function registerBundles()
{
    return [
        // ...
        new PaLabs\EndpointBundle\PaEndpointBundle(),
        // ...
    ];
}
```

Add route loading in app/config/routing.yml:
```yaml
endpoints:
  resource: .
  type: endpoints
```

Usage
---------

A simple endpoint look like 
```php
use PaLabs\EndpointBundle\EndpointInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TextEndpoint implements EndpointInterface {

    public function routes()
    {
       return new Route('/cool_message');
    }
    
    
    public function execute(Request $request): Response
    {
       return new Response('Hello, world');
    }
}
```
