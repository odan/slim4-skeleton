---
layout: default
title: Validation
nav_order: 14
---

# Validation

Depending on the use case, different strategies are appropriate for the input validation.

## OpenAPI validation

The [league/openapi-psr7-validator](https://github.com/thephpleague/openapi-psr7-validator) package can validate PSR-7 messages against OpenAPI (3.0.x) specifications expressed in YAML or JSON.

The [justinrainbow/json-schema](https://github.com/justinrainbow/json-schema) package is for validating JSON structures against a given schema.

## Form data validation

If you need to validate complex form data (arrays) against a specific set of rules, try 
[cakephp/validation](https://github.com/cakephp/validation) and [respect/validation](https://github.com/Respect/Validation).

To collect validation errors and convert a validation exception into a JSON response (422), try [selective/validation](https://github.com/selective-php/validation)

## XML validation

The [selective/xml](https://github.com/selective-php/xml) package validates XML files 
against XSD schemas.
