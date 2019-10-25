---
layout: default
title: Action
nav_order: 8
---

# Action

In an [ADR](https://github.com/pmjones/adr/blob/master/ADR.md) system, a single Action is the main purpose of a class or closure. Each Action would be represented by a individual class or closure.

The Action interacts with the Domain in the same way a Controller interacts with a Model but does not interact with a View or template system. It sends data to the Responder and invokes it so it can build the HTTP response.

## Single Action Controllers

The *Action* mediates between the *Domain* and the *Responder*. 

"Single Action Controllers" means: One action per class.

The *Action* does only these things:

* collects input from the HTTP request (if needed);
* invokes the Domain with those inputs (if required) and retains the result;
* invokes the Responder with any data the Responder needs to build an HTTP response (typically the HTTP Request and/or the Domain invocation results).

All other logic, including all forms of input validation, error handling, and so on, are therefore pushed out of the Action and into the Domain (for domain logic concerns) or the Responder (for presentation logic concerns). 

The [Responder](#responder) creates the response, not the Action.

A Responder might be HTML-responder for a standard web request; or 
it might be something like a JSON-responder for RESTful API requests.

### Example

```php
<?php

namespace App\Action;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExampleAction
{
    private $responseFactory;
    
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
    
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->responseFactory->createResponse();
        $response->getBody()->write('Hello, World!');

        return $response;
    }
}
```

**Pros and cons:** On the one hand we are producing more classes, on the other hand these action classes have only one responsibility (SRP).
Refactoring in your IDE becomes easy and safe, because the [routes](routing.md) make use of the `::class` constant. 

## Responder

To fully **separate the presentation logic**, each Action in ADR invokes a Responder to build the HTTP response. The Responder is entirely in charge of setting headers, setting the body content, picking content types, rendering templates, and so on.

Note that a Responder may incorporate a Template View or any other kind of body content building system.

A particular Responder may be used by more than one Action. The point here is the Action leaves all header and content work to the Responder, not that there must be a different Responder for each different Action.


## Request and Response

A quick overview of the request/response cycle in ADR:

![image](https://user-images.githubusercontent.com/781074/67461691-3c34a880-f63e-11e9-8266-2119ac98f639.png)

All requests go through the same cycle:  

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
