---
layout: default
title: Action
parent: The Basics
---

# Single Action Controller

The *Action* does only these things:

* It collects input from the HTTP request (if needed).
* It invokes the **Domain** with those inputs (if required) and retains the result.
* It builds an HTTP response (typically with the Domain results).

All other logic, including all forms of input validation, error handling, and so on,
are therefore pushed out of the Action and into the [Domain](domain.md)
(for domain logic concerns), or the response [Renderer](renderers.md) 
(for presentation logic concerns).

### Request and Response

Here is a brief overview of the typical application process that involves different participants:

* The **Slim router and dispatcher** receives an HTTP request and dispatches it to an **Action**.

* The **Action** invokes the **[Domain](domain.md)**, collecting any required inputs to the 
Domain from the HTTP request.

* The **Action** then invokes the **[Renderer](renderers.md)** with the data 
it needs to build an HTTP Response.

* The **Renderer** builds an HTTP response using the data fed to it by the **Action**.

* The **Action** returns the HTTP response to the **Slim response emitter** and sends 
the HTTP Response.

![Request and Response](https://user-images.githubusercontent.com/781074/169254509-109925c4-c34d-49d3-98a1-76ab463e2234.png)

## Example

```php
<?php

namespace App\Action;

use App\Domain\Example\Service\MyService;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleAction
{
    private MyService $myService;
    
    private JsonRenderer $renderer;
    
    public function __construct(MyService $myService, JsonRenderer $renderer)
    {
        $this->myService = $myService;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // 1. collect input from the HTTP request (if needed)
        $data = (array)$request->getParsedBody();
        
        // 2. Invokes the Domain (Application-Service)
        // with those inputs (if required) and retains the result
        $domainResult = $this->myService->doSomething($data);
        
        // 3. Build and return an HTTP response
        return $this->renderer->json($response, $domainResult);
    }
}
```
