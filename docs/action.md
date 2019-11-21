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
(for domain logic concerns) or the response renderer (for presentation logic concerns). 

A response could be rendered to HTML (e.g with Twig) for a standard web request; or 
it might be something like JSON for RESTful API requests.

**Note:** [Closures](https://www.php.net/manual/en/class.closure.php) (functions) as routing 
handlers are quite "expensive", because PHP has to create all closures on each request. 
The use of class names is more lightweight, faster and scales better for larger applications.

### Rendering a Twig template

```php
<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;

final class HomeAction
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->twig->render($response, 'home/home-index.twig');
    }
}
```

### Writing JSON to the response

Instead of calling `json_encode` everytime, you can use the `withJson()` method to render the response.

```php
<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

final class HomeAction
{
    public function __invoke(ServerRequest $request, Response $response): ResponseInterface
    {
        return $response->withJson(['success' => true]);
    }
}
```

## Responder

According to [ADR](#action-domain-responder-adr) there should be a **responder** for each action. In most cases this is not necessary 
and would blow up the code too much. Of course, you can add special responder classes and move the 
complete presentation logic there. 

**Examples**

* [JSON responder](https://github.com/odan/slim4-skeleton/blob/bbc3c8b7ccacfbd0a7f32758b2aeab5a888042f0/src/Responder/JsonResponder.php), [Usage](https://github.com/odan/slim4-skeleton/blob/bbc3c8b7ccacfbd0a7f32758b2aeab5a888042f0/src/Action/CreateUserAction.php)
* [HTML responder](https://github.com/odan/slim4-skeleton/blob/bbc3c8b7ccacfbd0a7f32758b2aeab5a888042f0/src/Responder/HtmlResponder.php), [Usage](https://github.com/odan/slim4-skeleton/blob/bbc3c8b7ccacfbd0a7f32758b2aeab5a888042f0/src/Action/TimeAction.php)
* [More examples](https://github.com/pmjones/adr-example/tree/master/src/Web/Blog)

## Request and Response

A quick overview of the request/response cycle:

![image](https://user-images.githubusercontent.com/781074/67461691-3c34a880-f63e-11e9-8266-2119ac98f639.png)

The requests are going through the [middleware](https://www.slimframework.com/docs/v4/concepts/middleware.html) stack (in and out):

> `Request > Front controller > Routing > Middleware > Action > Middleware > Response`

Here is a fully detailed HTTP request flow and back to the response:

![image](https://user-images.githubusercontent.com/781074/59540964-b2dad000-8eff-11e9-89da-aa98e400bd88.png)

[Fullscreen](https://user-images.githubusercontent.com/781074/59540964-b2dad000-8eff-11e9-89da-aa98e400bd88.png)

### Description

1. The user or the API client starts an HTTP request. 
2. The [front controller](https://en.wikipedia.org/wiki/Front_controller) `public/index.php` handles all requests. Create a PSR-7 request instance from the server request.
3. Dispatch the request to the router.
4. The router uses the HTTP method and the HTTP path to determine the appropriate action method.
5. The invoked controller action is responsible for:
   * Retrieving information from the request
   * Invoking the service and passing the parameters
   * Building the view data
   * Returning the response using a responder
6. The service is a use case handler and responsible for:
   * The business logic (validation, calculation, transaction handling, etc.)
   * Returning the result (optional)
7. The service can read ir write data to the database using a repository
8. The repository query handler creates a so called "use case optimal query" using a QueryBuilder
9. Execute the database query
10. Fetch the rows (result set) or the new primary key (ID) from the database
11. Map the row(s) to an object or a list of data objects. Optional use a data mapper to create the objects.
12. The repository returns the result
13. Do more calculations with the fetched data. Do more complex operations. Optional, commit or rollback the transaction.
14. Return the result
15. Create the view data for the responder (optional)
16. Pass the view data to the responder
17. Let the responder render the view data into the specific representation like html or json and build the PSR-7 response with the ResponseFactory. 
18. Return the response to the action method
19. Return the response to the router
20. Return the response to the front controller
21. The front controller emits the response using the SAPI Emitter
22. The emitter sends the HTTP headers and echos the HTTP body back to the client
