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
A service can be called directly from the action handler, a service, the console and from a test.

## Domain vs. Infrastructure

The infrastructure (layer) does not belong to the core application
because it acts like an external consumer to talk to your system,
for example the database, sending emails etc.

An Infrastructure service can be:

* Implementations for boundary objects, e.g. the repository classes (communication with the database)
* Web controllers (actions), console, etc.
* Framework-specific code

By separating domain from infrastructure code you automatically **increase testability**
because you can replace the implementation by changing the adapter without affecting 
the interface users.

Within the Domain layer you have multiple other types of classes, for example:

* Services with the business logic, aka. Use cases
* Value Objects, DTOs, Entities, aka. Model
* The repository (interfaces), for boundary objects to the infrastructure.

## Keep it clean

Most people may think that this pattern is not suitable because it results in too many files.
That this will result in more files is true, however these files are very small and focus on
exactly one specific task. You get very specific classes with only one clearly defined responsibility
(see SRP of SOLID). So you should not worry too much about too many files, instead you should worry
about too few and big files (fat controllers) with too many responsibilities.

## Read more

This architecture was inspired by the following resources and books:

* [The Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
* [The Onion Architecture](https://jeffreypalermo.com/2008/07/the-onion-architecture-part-1/)
* [Action Domain Responder](https://github.com/pmjones/adr)
* [Domain-Driven Design](https://amzn.to/3cNq2jV) (The blue book)
* [Implementing Domain-Driven Design](https://amzn.to/2zrGrMm) (The red book)
* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Alistair in the Hexagone](https://www.youtube.com/watch?v=th4AgBcrEHA)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Functional architecture](https://www.youtube.com/watch?v=US8QG9I1XW0&t=33m14s) (Video)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/) (Book)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019) (Slides)
* [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers)
* [On structuring PHP projects](https://www.nikolaposa.in.rs/blog/2017/01/16/on-structuring-php-projects/)
* [Standard PHP package skeleton](https://github.com/php-pds/skeleton)
* [Services vs Objects](https://dontpaniclabs.com/blog/post/2017/10/12/services-vs-objects)
* [Stop returning arrays, use objects instead](https://www.brandonsavage.net/stop-returning-arrays-use-objects-instead/)
* [Data Transfer Objects - What Are DTOs](https://www.youtube.com/watch?v=35QmeoPLPOQ)
* [SOLID](https://www.digitalocean.com/community/conceptual_articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design)
