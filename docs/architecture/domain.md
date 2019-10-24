---
layout: default
title: Domain
nav_order: 1
parent: Architecture
nav_order: 1
---

# Domain

## Services

Here is the right place for complex **business logic** e.g. calculation, validation, file creation etc.
Business logic is a step up on complexity over CRUD (Create, Read, Update and Delete) operations.

This layer provides cohesive, high-level logic for related parts of an application. This layer is invoked directly by the Controllers.

The business logic should be placed in the service classes, and we should aim for a fat model layer and thin controller layer.


### Best practices

Please don't prefix all service classes with `*Service`. 
A service class is not a "Manager" or "Utility" class. 

Think of the [SRP](http://pragmaticcraftsman.com/2006/07/single-responsibility-principle/) and give a service a "single responsibility".

> What changes for the same reason should be grouped together.
 
A service classes can, and should, have several methods as long as they serve a narrow purpose. 
This also encourages you to name your classes more specifically. Instead of a "User" god-class, 
you might have a `UserRegistration` class with a few methods focusing on registration.

> Q: Why would I change my UserRegistration class?<br>
> A: Because I'm changing how I register a user<br>
> A: And not because I'm changing how I assign a user to a task. Because that's being handled by the UserTaskAssignment class.<br>

## Repositories

There are two types of repositories: collection-oriented and persistence-oriented repositories. 
In this case, we are talking about **persistence-oriented repositories**, since these are better 
suited for processing large amounts of data.

A repository is the source of all the data your application needs 
and mediates between the service and the database. A repository improves code maintainability, testing and readability by separating `business logic` 
from `data access logic` and provides centrally managed and consistent access rules for a data source. 
Each public repository method represents a query. The return values represent the result set 
of a query and can be primitive/object or list (array) of them. Database transactions must 
be handled on a higher level (service) and not within a repository.

Quick summary:

* Communication with the database.
* Place for the data access (query) logic.
* Uses data mapper to create domain objects
* This is no place for the business logic! Use [services](#services) for the business logic.


## Data Transfer Objects (DTO) 
  
A DTO contains only pure **data**. There is no business or domain specific logic, only simple validation logic. There is also no database access within a DTO. A service fetches data from a repository and  the repository (or the service) fills the DTO with data. A DTO can be used to transfer data inside or outside the domain.

Example:

```php
<?php

namespace App\Domain\Customer\Data;

final class CustomerData
{
    /** @var string */
    public $name;
    
    /** @var string */
    public $email;
    
    /** @var \DateTimeImmutable */
    public $dateOfBirth;
}
```

## Value Objects

Use it only for "small things" like Date, Money, CustomerId and as replacement for primitive data type like string, int, float, bool, array. 

A value object must be **immutable** and is responsible for keeping their state consistent. 

A value object should only be filled using the constructor.

Wither methods are allowed, but `setter` methods are not allowed. 

Example: 

```php
public function withEmail(string $email): self { ... }
```

A getter method name does not contain a `get` prefix. 

Example: 

```php
public function email(): string { return $this->email; }`. 
```

All properties must be `protected` or `private` accessed by the getter methods.

Example:

```php
<?php

class CustomerId
{
    private $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }
    
    public function equals(CustomerId $customerId): bool
    {
        return $this->id == $customerId->id;
    }
    
    public function __toString()
    {
        return (string)$this->id;
    }
}
```

[Read more](https://kacper.gunia.me/validating-value-objects/)

## Parameter objects

If you have a lot of parameters that fit together, 
you can replace them with a parameter object. See [DTO](#data-transfer-object-dto)

## Types and enums

Don't use strings or fix integer codes as values. Instead use public class constants.

Example:

```php
<?php

final class LevelType
{
    public const LOW = 1;
    public const MEDIUM = 2;
    public const HIGH = 3;
}
```
