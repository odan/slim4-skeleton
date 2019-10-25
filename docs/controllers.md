---
layout: default
title: Controllers
nav_order: 8
---

# Single Action Controllers

The *Action* mediates between the *Domain* and the *Responder*. 

"Single Action Controllers" means: One action per class.

The *Action* does only these things:

1. collects input from the HTTP request (if needed);
2. invokes the Domain with those inputs (if required) and retains the result;
3. invokes the Responder with any data the Responder needs to build an HTTP response (typically the HTTP Request and/or the Domain invocation results).

All other logic, including all forms of input validation, error handling, and so on, are therefore pushed out of the Action and into the Domain (for domain logic concerns) or the Responder (for presentation logic concerns). 

The Responder creates the response, not the action.

A Responder might be HTML-responder for a standard web request; or, 
it might be something like JSON-responder for a RESTful API requests.

### Example

```php
<?php

namespace App\Action;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleAction
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

**Pros and cons:** On the one hand we are producing more classes, on the other hand these action classes have only one responsibility (SRP).
Refactoring becomes easy and safe, because the routes in `routes.php` make use of the `::class` constant. 

Read more: [ADR](architecture.md#action-domain-responder-adr)
