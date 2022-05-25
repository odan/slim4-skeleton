---
layout: default
title: Domain
parent: The Basics
---

# Domain

The Domain layer is the core of the application.

## Services

Here is the right place for complex **business logic** e.g. calculation, validation, transaction handling, file creation etc.
Business logic is a step-up on complexity over CRUD (Create, Read, Update and Delete) operations.

An (application) service can be called directly from the action, a service, the CLI and the unit tests.

By separating behavior from data, it's possible to build and maintain non-trivial applications over many years.
This architecture also respects the [SOLID](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design) principles to be [TDD](https://hackernoon.com/introduction-to-test-driven-development-tdd-61a13bc92d92) - friendly as much as possible.

Read more: [Services vs Objects](https://dontpaniclabs.com/blog/post/2017/10/12/services-vs-objects)

## Domain vs. Infrastructure

**Domain**

* **Use cases:** Services with the business logic
* **Model:** Value Objects, DTOs, Entities
* **Interfaces for boundary objects:** The repository interfaces

**Infrastructure**

* Framework-specific code
* Implementations for boundary objects, e.g. the repository classes (communication with the database)
* Web controllers (actions), CLI, etc.


## Repositories

A [repository](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html) 
is the source of all the (database) data your application needs and mediates between the domain and data mapping layers. 
A repository improves code maintainability, testing and readability by separating **business logic** 
from **data access logic** and provides centrally managed and consistent access rules for a data source.

There are two types of repositories: collection-oriented and persistence-oriented repositories. 
In this case, we are talking about **persistence-oriented repositories**, since these are better 
suited for processing large amounts of data.
 
Each public repository method represents a query. The return values represent the result set 
of a query and can be primitive/object or list (array) of them. Database transactions must 
be handled on a higher level (service) and not within a repository.

**Quick summary:**

* Communication with the database.
* Place for the data access (query) logic.
* Uses data mapper to create domain objects
* This is no place for the business logic. Use [services](#services) for the business logic.

## Advantages

* By separating domain from infrastructure code you automatically **increase testability**
* You can replace an **adapter** without affecting the **ports**
* You can **postpone** the choice for database vendor, framework, query builder, mailer, etc.
* You can more easily **keep up** with the change rate of the framework-specific code...
* or replace the framework altogether

## Keep it clean

Most people may think that this pattern is not suitable because it results in too many files.
That this will result in more files is true, however these files are very small and focus on
exactly one specific task. You get very specific classes with only one clearly defined responsibility
(see SRP of SOLID). So you should not worry too much about too many files, instead you should worry
about too few and big files (fat controllers) with too many responsibilities.

## Read more

This architecture was inspired by the following resources and books:

* [The Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
* [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers)
* [Action Domain Responder](https://github.com/pmjones/adr)
* [Domain-Driven Design](https://amzn.to/3cNq2jV) (The blue DDD book)
* [Implementing Domain-Driven Design](https://amzn.to/2zrGrMm) (The red DDD book)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/) (Book)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019) (
  Slides)
* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Alistair in the Hexagone](https://www.youtube.com/watch?v=th4AgBcrEHA)
