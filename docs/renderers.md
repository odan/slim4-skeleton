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

## TemplateRenderer

Renders data to HTML, using the native PHP template engine for rendering. 

Media type: `text/html`

Methods:

* `template` - Renders a (PHP) template

```php
<?php

namespace App\Action;

use App\Renderer\HtmlRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    private HtmlRenderer $renderer;
    
    public function __construct(HtmlRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $viewData = [];
        
        return $this->renderer->template($response, 'home/index.php', $viewData);
    }
}
```

## RedirectRenderer

Methods:

* `redirect` - Builds a redirect for the given url
* `redirectFor` - Builds a redirect for the given route name

## Building a filetype specific response

* [Image files](https://odan.github.io/2020/05/07/slim4-working-with-images.html)
* [Excel files](https://odan.github.io/2017/12/16/creating-and-downloading-excel-files-with-slim.html)
* [ZIP files](https://github.com/selective-php/zip-responder)
