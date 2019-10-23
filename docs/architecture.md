---
layout: default
title: Architecture
nav_order: 3
---

## Architecture

This is a **service oriented**, MVC 2 architecture for enterprise applications. 

* **Model:** The core application, business logic, data manipulation
* **View:** Presentation layer, display of information
* **Controller:** Mediates between View and Model

![image](https://user-images.githubusercontent.com/781074/59565895-13315500-9059-11e9-9815-34ce85ed498a.png)

The **model layer** (M) is divided into multiple sub-categories:

* **Service:** Business logic (calculation, validation, transaction handling)
* **Repository:** Data access logic, communication with databases
* **Data:** Domain objects with data (without complex logic) e.g. Value Objects, DTOs


### Service-Oriented Architecture (SOA)

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

### A HTTP Request and response

A typical HTTP request data flow and back to the response:

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
