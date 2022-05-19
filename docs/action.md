---
layout: default
title: Action
parent: The Basics
---

# Single Action Controller

Single Action Controllers are controllers that do one thing and one thing only.

* It collects input from the HTTP request (if needed).
* It invokes the **Domain** with those inputs (if required) and retains the result.
* It builds an HTTP response (typically with the Domain results).

All other logic, including all forms of input validation, error handling, and so on,
are therefore pushed out of the Action and into the [Domain](domain.md)
(for domain logic concerns), or the response [Renderer](renderers.md) (for presentation logic concerns).

## Collaborations

* The **Slim router and dispatcher** receives an HTTP Request and dispatches it to an **Action**.

* The **Action** invokes the **[Domain](domain.md)**, collecting any required inputs to the 
Domain from the HTTP request.

* The **Action** then invokes the **[Renderer](renderers.md)** with the data 
it needs to build an HTTP Response.

* The **Renderer** builds an HTTP response using the data fed to it by the **Action**.

* The **Action** returns the HTTP response to the **Slim response emitter** and sends 
the HTTP Response.

A quick overview of the request/response cycle:

![image](https://user-images.githubusercontent.com/781074/169254509-109925c4-c34d-49d3-98a1-76ab463e2234.png)

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

## Keep it clean

Most people may think that this pattern is not suitable because it results in too many files.
That this will result in more files is true, however these files are very small and focus on
exactly one specific task. You get very specific classes with only one clearly defined responsibility
(see SRP of SOLID). So you should not worry too much about too many files, instead you should worry
about too few and big files (fat controllers) with too many responsibilities.

## Read more

This architecture was inspired by the following resources and books:

* [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers)
* [Software Architecture for Web Applications and APIs](https://ko-fi.com/s/811e7a3593)
* [Action Domain Responder](https://pmjones.io/adr/)
* [The Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
* [Domain-Driven Design](https://amzn.to/3cNq2jV) (The blue DDD book)
* [Implementing Domain-Driven Design](https://amzn.to/2zrGrMm) (The red DDD book)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/) (Book)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019) (
  Slides)
* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Alistair in the Hexagone](https://www.youtube.com/watch?v=th4AgBcrEHA)
