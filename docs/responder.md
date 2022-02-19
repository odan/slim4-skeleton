---
layout: default
title: Responder
parent: Architecture
nav_order: 3
---

# Responder

***Responder** is the presentation logic to build an HTTP Response using data 
it receives from the Action. It deals with status codes, headers and cookies, 
content, formatting and transformation, templates and views, and so on.*

According to [ADR](https://github.com/pmjones/adr) there should be a 
**Responder** for each action.

An extra Responder class would make sense when building a [transformation layer](resources.md)
for complex (JSON or XML) data output. 

This helps to separate the presentation logic from the domain logic.
