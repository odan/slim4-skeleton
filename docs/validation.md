---
layout: default
title: Validation
parent: Advanced
---

# Validation

There are different approaches to validate your application's incoming data.

## Form and JSON validation

This project comes with [cakephp/validation](https://github.com/cakephp/validation)
and contains some validation examples.

**Read more**

* [Slim 4 - CakePHP Validation](https://ko-fi.com/s/5f182b4b22)
* [Slim 4 - Symfony Validator](https://ko-fi.com/s/5f182b4b22)

## OpenAPI validation

The [league/openapi-psr7-validator](https://github.com/thephpleague/openapi-psr7-validator)
package can validate PSR-7 messages against OpenAPI (3.0.x) specifications expressed in YAML or JSON.

The [justinrainbow/json-schema](https://github.com/justinrainbow/json-schema) package is
for validating JSON structures against a given schema.

## JSON schema validation

The [league/json-guard](https://json-guard.thephpleague.com/) package lets you validate JSON data
using [json schema](https://json-schema.org/).

## XML validation

The [DOMDocument::schemaValidate](https://www.php.net/manual/en/domdocument.schemavalidate.php)
method is able to validate XML files against a XSD schema.

## Assertions

The [webmozart/assert](https://github.com/webmozart/assert) and
[beberlei/assert](https://github.com/beberlei/assert)
package provides assertions to validate method input/output with nice error messages.

