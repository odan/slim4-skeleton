## Architecture

This is a multi-layered MVC 2 architecture for enterprise applications. 

* **Model:** The core application, business logic, data manipulation
* **View:** Presentation layer, display of information
* **Controller:** Mediates between View and Model

![image](https://user-images.githubusercontent.com/781074/59565895-13315500-9059-11e9-9815-34ce85ed498a.png)

The **model layer** (M) is divided into multiple sub-categories:

* **Service:** Business logic (calculation, validation, transaction handling)
* **Repository:** Data access logic, communication with databases
* **Data:** Domain objects with data (without complex logic) e.g. Value Objects, DTOs

In a **Service-Oriented Architecture (SOA)** we are seperating the **behavior** and the **data**. Please do not confuse it with classic **OOP**, where behavior and data belongs togehter. By seperating behavior from data, it's possible to build and maintain non-trivial applications over many years.

This architecture also respects the SOLID principles to be TDD-friendly as much as possible.

### Overview

A typical HTTP reqest data flow and back to the response:

![image](https://user-images.githubusercontent.com/781074/59540964-b2dad000-8eff-11e9-89da-aa98e400bd88.png)

[Fullscreen](https://user-images.githubusercontent.com/781074/59540964-b2dad000-8eff-11e9-89da-aa98e400bd88.png)

### Description

1. The user or the API client starts an HTTP request. 
2. The [front controller](https://en.wikipedia.org/wiki/Front_controller) `public/index.php` handles all requests. Create a PSR-7 request instance from the server request.
3. Dispatch the request to the router.
4. The router uses the HTTP method and the HTTP path to determine the appropriate action method.
5. The invoked controller action is responsible for:
   * Retrieving informations from the request
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
13. Do more calulations with the fetched data. Do more complex operations. Optional, commit or rollback the transaction.
14. Return the result
15. Create the view data for the responder (optional)
16. Pass the view data to the responder
17. Let the responder render the view data into the specific representation like html or json and build the PSR-7 response with the ResponseFactory. 
18. Return the response to the action method
19. Return the response to the router
20. Return the response to the front controller
21. The front controller emits the response using the SAPI Emitter
22. The emitter sends the HTTP headers and echos the HTTP body back to the client

<hr>

Navigation: [Index](readme.md)
