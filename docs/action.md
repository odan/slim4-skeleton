---
layout: default
title: Action
parent: Architecture
nav_order: 1
---

# Action

***Action** is the logic to connect the Domain and Responder. 
It invokes the Domain with inputs collected from the HTTP Request, 
then invokes the Responder with the data needed to build an HTTP Response.*

## Collaborations

1. The web handler receives an HTTP Request and dispatches it to an Action.

2. The Action invokes the Domain, collecting any required inputs to the Domain from the HTTP Request.

3. The Action then invokes the Responder with the data it needs to build an HTTP Response (typically the HTTP Request and the Domain results, if any).

4. The Responder builds an HTTP Response using the data fed to it by the Action.

5. The Action returns the HTTP Response to the web handler sends the HTTP Response.

## Single Action Controller

Each **Single Action Controller** is represented by a dedicated class or closure.

The *Action* does only these things:

* collects input from the HTTP request (if needed)
* invokes the **Domain** with those inputs (if required) and retains the result
* builds an HTTP response (typically with the Domain invocation results).

All other logic, including all forms of input validation, error handling, and so on, 
are therefore pushed out of the Action and into the **Domain** 
(for domain logic concerns), or the response renderer (for presentation logic concerns). 

A response could be rendered to HTML (e.g. with Twig) for a standard web request; or 
it might be something like JSON for RESTful API requests.

Most people may think that this pattern is not suitable because it results in too many files.
That this will result in more files is true, however these files are very small and focus on
exactly one specific task. You get very specific classes with only one clearly defined responsibility
(see SRP in SOLID). So you should not worry too much about too many files, instead you should worry
about too few and big files (fat controllers) with too many responsibilities.

**Pseudo Example**

```php
<?php

namespace App\Action;

use App\Domain\Example\Service\MyService;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

final class ExampleAction
{
    /**
     * @var MyService
     */
    private $myService;
    
    /**
     * @var Responder
     */
    private $responder;
    
    public function __construct(MyService $myService, Responder $responder)
    {
        $this->myService = $myService;
        $this->responder = $responder;
    }

    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        // 1. collect input from the HTTP request (if needed)
        $data = (array)$request->getParsedBody();
        
        // 2. Invokes the Domain (Application-Service)
        // with those inputs (if required) and retains the result
        $domainResult = $this->myService->doSomething($data);
        
        // 3. Build and return a HTTP response
        return $this->responder->withJson($domainResult);
    }
}
```
