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

## Building a filetype specific response

* [Image files](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Excel files](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [PDF files](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [ZIP files](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [TCPDF](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
