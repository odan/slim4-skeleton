---
layout: default
title: API Resources
parent: The Basics
---

# API Resources

When building an API, you may need a transformation layer that sits between 
your Service and the JSON responses that are actually returned 
to your application's users. For example, you may wish to display certain 
attributes for a subset of users and not others, or you may wish to always 
include certain relationships in the JSON representation of your data. 

## Transformer

A Transformer provides a presentation and transformation layer for complex data output, the like in RESTful APIs.
Transformers contain the logic for changing a data format to whatever you need for the output, for example JSON.
To goal is to create a "barrier" between source data and output, so schema changes do not affect users.

The [selective/transformer](https://github.com/selective-php/transformer) component
allows you to expressively and easily transform your data into any dynamic (JSON) data structure.

There is also [league/fractal](https://fractal.thephpleague.com/),
which provides a presentation and transformation layer for complex [JSON-APIs](https://jsonapi.org/).

The [laminas/laminas-hydrator](https://docs.laminas.dev/laminas-hydrator/v4/quick-start/)
component provides functionality for **hydrating** objects
(which is the act of populating an object from a set of data) 
and **extracting** data from them.

