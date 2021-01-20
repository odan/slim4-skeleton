---
layout: default
title: Action
parent: Architecture
nav_order: 1
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

Most people may think that this pattern is not suitable because it results in too many files.
That this will result in more files is true, however these files are very small and focus on
exactly one specific task. You get very specific classes with only one clearly defined responsibility
(see SRP in SOLID). So you should not worry too much about too many files, instead you should worry
about too few and big files (fat controllers) with too many responsibilities.

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
        return $this->responder->withTemplate($response, 'home/home-index.twig');
    }
}
```

### Writing JSON to the response

Instead of calling `json_encode` everytime, you can use the responder `withJson()` method to render the response.

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

### VSCode Snippet

[Snippets in Visual Studio Code - Create your own snippets](https://code.visualstudio.com/docs/editor/userdefinedsnippets#_create-your-own-snippets).

Should be added to file `Code/User/snippets/php.json`.

For quick access start typing `class` in new PHP file(after `<?php` line) then pick snippet from dropdown.

```json
    "slim4 skeleton action class": {
        "prefix": "class",
        "body": [
            "namespace App\\Action\\\\${TM_DIRECTORY/^.+\\/(.*)$/$1/};",
            "",
            "use App\\Responder\\Responder;",
            "use Psr\\Http\\Message\\ResponseInterface;",
            "use Psr\\Http\\Message\\ServerRequestInterface;",
            "",
            "/**",
            " * Action.",
            " */",
            "final class $TM_FILENAME_BASE",
            "{",
            "    /**",
            "     * @var Responder",
            "     */",
            "    private \\$responder;",
            "",
            "    /**",
            "     * The constructor.",
            "     *",
            "     * @param Responder \\$responder The responder",
            "     */",
            "    public function __construct(Responder \\$responder)",
            "    {",
            "        \\$this->responder = \\$responder;",
            "    }",
            "",
            "    /**",
            "     * Action.",
            "     *",
            "     * @param ServerRequestInterface \\$request The request",
            "     * @param ResponseInterface \\$response The response",
            "     *",
            "     * @return ResponseInterface The response",
            "     */",
            "    public function __invoke(ServerRequestInterface \\$request, ResponseInterface \\$response): ResponseInterface",
            "    {",
            "        return \\$this->responder->withTemplate(\\$response, '${TM_DIRECTORY/^.+\\/(.*)$/${1:/downcase}/}/$0.twig');",
            "    }",
            "}",
            ""
        ],
        "description": "Slim4 skeleton action class"
    },
```
