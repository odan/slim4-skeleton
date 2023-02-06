---
layout: default
title: Renderers
parent: The Basics
---

# Renderer

This skeleton projects includes a number of
built-in Renderer classes, that allow you to 
return responses with various media types. 

There is also support for defining your own custom renderers, 
which gives you the flexibility to design your own media types.

## JsonRenderer

Renders the response data into JSON, using utf-8 encoding.

Media type: `application/json`

Methods:

* `json` - Builds a JSON response

```php
<?php

namespace App\Action;

use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    private JsonRenderer $renderer;
    
    public function __construct(JsonRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->renderer->json($response, ['success' => true]);
    }
}
```

## RedirectRenderer

Methods:

* `redirect` - Builds a redirect for the given url
* `redirectFor` - Builds a redirect for the given route name

## Building a filetype specific response

* [Slim 4 - Image files](https://ko-fi.com/s/5f182b4b22) (eBook)
* [Slim 4 - Excel files](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
* [Slim 4 - PDF files](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
* [Slim 4 - ZIP files](https://ko-fi.com/s/e592c10b5f) (eBook Vol. 2)
