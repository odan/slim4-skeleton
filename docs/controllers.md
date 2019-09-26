## Controllers

After passing through all assigned middleware, the request will be processed by a (controller) action.

The Controller's job is to translate incoming requests into outgoing responses. 

In order to do this, the controller must take request data, checks for authorization,
and pass it into the domain service layer.

The domain service layer then returns data that the Controller injects into a View for rendering. 

A view might be HTML for a standard web request; or, 
it might be something like JSON for a RESTful API request.

This application uses `Single Action Controllers` which means: One action per class.

A typical action method signature should look like this:

```php
public function __invoke(ServerRequestInterface $request): ResponseInterface
```

The container autowire-feature will automatically inject all dependencies for you via constructor injection.

**Action example class:**

```php
<?php

namespace App\Action;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExampleAction implements ActionInterface
{
    private $responseFactory;
    
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
    
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();
        $response->getBody()->write('Hello, World!');

        return $response;
    }
}
```

This concept will produce more classes, but these action classes have only one responsibility (SRP).
Refactoring action classes is very easy now, because the routes in `routes.php` make use of the `::class` constant. 

<hr>

Navigation: [Index](readme.md)