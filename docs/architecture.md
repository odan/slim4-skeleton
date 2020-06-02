---
layout: default
title: Architecture
nav_order: 3
has_children: true
---

# Architecture

This application uses the [ADR](#action-domain-responder-adr) pattern and a [hexagonal architecture](#hexagonal-architecture) with a [service-oriented](domain.md#service-oriented-architecture-soa) domain layer.  

## Action Domain Responder

**ADR** is a user interface pattern specifically intended for server-side applications operating in an over-the-network, request/response environment.

The modern derivations of "MVC Model 2"  toward Action Domain Responder is not difficult. 

* **[Action](action.md):** Mediates between Domain and Responder
* **[Domain](domain.md):** The core application with the business logic.
* **[Responder](action.md#responder):** Presentation logic. The Responder builds the HTTP response.

Read more: [ADR](https://github.com/pmjones/adr/blob/master/ADR.md)

## Read more

This architecture was inspired by the following resources and books:

* [Action Domain Responder](https://pmjones.io/adr/)
* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Domain-Driven Design](https://amzn.to/3cNq2jV) (The blue book)
* [Implementing Domain-Driven Design](https://amzn.to/2zrGrMm) (The red book)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/) (Book)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019) (Slides)
* [Continuous Delivery](https://amzn.to/2Y9SBUs)

