---
layout: default
title: Responder
nav_order: 9
---

# Responder

According to [ADR](https://github.com/pmjones/adr) there should be a **responder** for each action.
In most cases a generic responder (see [Responder.php](https://github.com/odan/slim4-skeleton/blob/master/src/Responder/Responder.php))
is good enough. Of course, you can add special responder classes and move the complete presentation logic there.
An extra responder class would make sense when [building an transformation layer](https://fractal.thephpleague.com/)
for complex (json or xml) data output. This helps to separate the presentation logic from the domain logic.

## Request and Response

A quick overview of the request/response cycle:

![image](https://user-images.githubusercontent.com/781074/67461691-3c34a880-f63e-11e9-8266-2119ac98f639.png)

The requests are going through the [middleware](https://www.slimframework.com/docs/v4/concepts/middleware.html)
stack (in and out):

> `Request > Front controller > Routing > Middleware > Action > Middleware > Response`

Here is a fully detailed HTTP request flow and back to the response:

![image](https://user-images.githubusercontent.com/781074/59540964-b2dad000-8eff-11e9-89da-aa98e400bd88.png)

[Fullscreen](https://user-images.githubusercontent.com/781074/59540964-b2dad000-8eff-11e9-89da-aa98e400bd88.png)

### Description

1. The user or the API client starts an HTTP request.
2. The [front controller](https://en.wikipedia.org/wiki/Front_controller) `public/index.php` handles all requests.
   Create a PSR-7 request instance from the server request.
3. Dispatch the request to the router.
4. The router uses the HTTP method, and the HTTP path to determine the appropriate action method.
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
11. Map the row(s) to an object, or a list of data objects. Optional use a data mapper to create the objects.
12. The repository returns the result
13. Do more calculations with the fetched data. Do more complex operations. Optional, commit or rollback the transaction.
14. Return the result
15. Create the view data for the responder (optional)
16. Pass the view data to the responder
17. Let the responder render the view data into the specific representation like html or json and build the
    PSR-7 response with the ResponseFactory.
18. Return the response to the action method
19. Return the response to the router
20. Return the response to the front controller
21. The front controller emits the response using the SAPI Emitter
22. The emitter sends the HTTP headers and echos the HTTP body back to the client

**Read more:**

* [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers)
