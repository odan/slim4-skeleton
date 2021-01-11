---
layout: default
title: Action
nav_order: 8
---

# Action

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

**Note:** [Closures](https://www.php.net/manual/en/class.closure.php) (functions) as routing 
handlers are quite "expensive", because PHP has to create all closures on each request. 
The use of class names is more lightweight, faster and scales better for larger applications.

### Rendering a Twig template

```php
<?php

namespace App\Action;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

final class HomeAction
{
    /**
     * @var Responder
     */
    private $responder;
    
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->responder->render($response, 'home/home-index.twig');
    }
}
```

### Writing JSON to the response

Instead of calling `json_encode` everytime, you can use the responder `json()` method to render the response.

```php
<?php

namespace App\Action;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

final class HomeAction
{
    /**
     * @var Responder
     */
    private $responder;
    
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }
    
    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->responder->json(['success' => true]);
    }
}
```

