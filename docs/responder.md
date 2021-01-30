---
layout: default
title: Responder
parent: Architecture
nav_order: 3
---

# Responder

***Responder** is the presentation logic to build an HTTP Response using data 
it receives from the Action. It deals with status codes, headers and cookies, 
content, formatting and transformation, templates and views, and so on.*

According to [ADR](https://github.com/pmjones/adr) there should be a **Responder** for each action.
In most cases a generic responder (see [Responder.php](https://github.com/odan/slim4-skeleton/blob/master/src/Responder/Responder.php))
is good enough. Of course, you can add special Responder classes and move the complete presentation logic there.

An extra Responder class would make sense when building a [transformation layer](resources.md)
for complex (JSON or XML) data output. This helps to separate the presentation logic from the domain logic.

## Generic Responder

The generic `App\Responder\Responder` class provides the following helper methods:

* `createResponse` - Create a new response
* `withJson` - Builds a JSON response
* `withTemplate` - Renders a (PHP) template
* `withRedirect` - Builds a redirect for the given url
* `withRedirectFor` - Builds a redirect for the given route name

## Rendering templates

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
        $viewData = [];
        
        return $this->responder->withTemplate($response, 'home/index.php', $viewData);
    }
}
```

## Building a JSON response

Instead of calling `json_encode` everytime,
you can use the `withJson()` method of the Responder
to generate a full JSON response.

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
        return $this->responder->withJson(['success' => true]);
    }
}
```

## Building a filetype specific response

* [Image files](https://odan.github.io/2020/05/07/slim4-working-with-images.html)
* [Excel files](https://odan.github.io/2017/12/16/creating-and-downloading-excel-files-with-slim.html)
* [ZIP files](https://github.com/selective-php/zip-responder)
