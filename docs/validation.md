---
layout: default
title: Validation
parent: Advanced
---

# Validation

There are different approaches to validate your application's incoming data.

## Form and JSON validation

**Additional Resources**

* [CakePHP Validation](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Symfony Validator](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Problem Details for HTTP API](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)

## OpenAPI-based Validation

The [league/openapi-psr7-validator](https://github.com/thephpleague/openapi-psr7-validator)
package can validate PSR-7 messages against OpenAPI (3.0.x) specifications expressed in YAML or JSON.

**Additional Resources**

* [OpenAPI Validation](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)

## JSON schema validation

The [league/json-guard](https://json-guard.thephpleague.com/) package 
allows you to validate JSON data against a 
[JSON schema](https://json-schema.org/).

## XML validation

The [DOMDocument::schemaValidate](https://www.php.net/manual/en/domdocument.schemavalidate.php)
method is able to validate XML files against a XSD schema.

**Additional Resources**

* [XML Validation](https://ko-fi.com/s/3698cf30f3) (XML Validation (Slim 4 - eBook Vol. 3)

## Assertion-Based Validation

For assertion based input/output validation, you may use:

* [webmozart/assert](https://github.com/webmozart/assert)
* [beberlei/assert](https://github.com/beberlei/assert)

This provides a range of assertion methods for enhanced data validation.
