---
layout: default
title: Architecture
nav_order: 3
has_children: true
---

# Architecture

This application uses the [ADR](#action-domain-responder-adr) pattern and a hexagonal architecture with a [service-oriented](#service-oriented-architecture-soa) domain layer.  

## Action Domain Responder (ADR)

ADR is a user interface pattern specifically intended for server-side applications operating in an over-the-network, request/response environment.

The modern derivations of "MVC Model 2"  toward Action Domain Responder is not difficult. 

* **Action:** Mediates between Domain and Responder
* **Domain:** The core application with the business logic. The place for domain-driven design patterns such as Application Service.
* **Responder:** Presentation logic. The Responder builds the HTTP response.

Read more: [ADR](https://github.com/pmjones/adr/blob/master/ADR.md)

### Action

In an ADR system, a single Action is the main purpose of a class or closure. Each Action would be represented by a individual class or closure.

The Action interacts with the Domain in the same way a Controller interacts with a Model but does not interact with a View or template system. It sends data to the Responder and invokes it so it can build the HTTP response.

### Domain

The **Domain** is divided into multiple sub-categories:

* **Service:** Business logic (calculation, validation, transaction handling)
* **Repository:** Data access logic, communication with databases
* **Data:** Domain objects with data (without complex logic) e.g. Value Objects, DTOs

Read more: [Domain](architecture/domain.md)

### Responder

To fully **separate the presentation logic**, each Action in ADR invokes a Responder to build the HTTP response. The Responder is entirely in charge of setting headers, setting the body content, picking content types, rendering templates, and so on.

Note that a Responder may incorporate a Template View or any other kind of body content building system.

A particular Responder may be used by more than one Action. The point here is the Action leaves all header and content work to the Responder, not that there must be a different Responder for each different Action.

## Service-Oriented Architecture (SOA)

**SOA** uses **services** to build systems. **OOP** uses **objects** to build systems, and it tends marry data and behavior. Services tend to **separate data from behavior**. In an SOA, the separation between data and behavior is often obvious.

**OOP**

```php 
$sourceAccount = new Account(100);
$destinationAccount = new Account(0);
$sourceAccount->transfer(100, $destinationAccount);
```

**SOA**

```php
$sourceAccount = new Account(100);
$destinationAccount = new Account(0);
$service = new AccountService();
$service->transfer(100, $sourceAccount, $destinationAccount);
```

By separating behavior from data, it's possible to build and maintain non-trivial applications over many years.
This architecture also respects the [SOLID](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design) principles to be [TDD](https://hackernoon.com/introduction-to-test-driven-development-tdd-61a13bc92d92) - friendly as much as possible.

Read more: [Services vs Objects](https://dontpaniclabs.com/blog/post/2017/10/12/services-vs-objects)

## Request and response

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

## Read more

* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)

