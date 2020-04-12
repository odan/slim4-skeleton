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
* **[Domain](domain.md):** The core application with the business logic. The place for domain-driven design patterns such as Application Service.
* **[Responder](action.md#responder):** Presentation logic. The Responder builds the HTTP response.

Read more: [ADR](https://github.com/pmjones/adr/blob/master/ADR.md)

**Opinion:** I think leaving out the responder part is not bad practice. 
I try to be more "pragmatic". I think most of the time for example
your template engine (e.g. Twig) acts  an "HTML Responder". 
So you don't need a special responder class for each action.
                    
A responder is useful if you have repetitive action tasks, 
such as creating an HTTP redirect or creating a JSON response. 
For such a use case a special responder would make sense for me.

## Hexagonal Architecture

Read more:

* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)

