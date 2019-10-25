---
layout: default
title: Architecture
nav_order: 3
has_children: true
---

# Architecture

This application uses the [ADR](#action-domain-responder-adr) pattern and a [hexagonal architecture](#hexagonal-architecture) with a [service-oriented](domain.md#service-oriented-architecture-soa) domain layer.  

## Action Domain Responder (ADR)

ADR is a user interface pattern specifically intended for server-side applications operating in an over-the-network, request/response environment.

The modern derivations of "MVC Model 2"  toward Action Domain Responder is not difficult. 

* **Action:** Mediates between Domain and Responder
* **Domain:** The core application with the business logic. The place for domain-driven design patterns such as Application Service.
* **Responder:** Presentation logic. The Responder builds the HTTP response.

Read more: [ADR](https://github.com/pmjones/adr/blob/master/ADR.md)

## Action

In an ADR system, a single Action is the main purpose of a class or closure. Each Action would be represented by a individual class or closure.

The Action interacts with the Domain in the same way a Controller interacts with a Model but does not interact with a View or template system. It sends data to the Responder and invokes it so it can build the HTTP response.

Read more: [Single Controllers Controllers](action.md)

## Domain

Read more: [Domain](architecture/domain.md)

## Responder

To fully **separate the presentation logic**, each Action in ADR invokes a Responder to build the HTTP response. The Responder is entirely in charge of setting headers, setting the body content, picking content types, rendering templates, and so on.

Note that a Responder may incorporate a Template View or any other kind of body content building system.

A particular Responder may be used by more than one Action. The point here is the Action leaves all header and content work to the Responder, not that there must be a different Responder for each different Action.

## Hexagonal Architecture

Read more:

* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)

