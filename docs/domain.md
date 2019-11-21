---
layout: default
title: Domain
nav_order: 9
---

# Domain

## Domain vs. Infrastructure

**Domain**

* **Use cases:** Application services with the business logic
* **Model:** Value Objects, DTOs, Entities
* **Interfaces for boundary objects:** The repository interfaces

**Infrastructure**

* Framework-specific code
* Implementations for boundary objects, e.g. the repository classes (communication with database)
* Web controllers (actions), CLI, etc.

## Advantages

* By separating domain from infrastructure code you automatically **increase testability**
* You can replace an **adapter** without affecting the **ports**
* You can **postpone** the choice for database vendor, framework, query builder, ORM, etc.
* You can more easily **keep up** with the change rate of the framework-specific code...
* or replace the framework altogether

**Read more**

* [Alistair in the Hexagone](https://www.youtube.com/watch?v=th4AgBcrEHA)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/)

## Services

Here is the right place for complex **business logic** e.g. calculation, validation, transaction handling, file creation etc.
Business logic is a step up on complexity over CRUD (Create, Read, Update and Delete) operations.

An (application) service can be called directly from the action, a service, the CLI and the unit tests.

### Service-Oriented Architecture (SOA)

**SOA** uses **services** to build systems. 
**OOP** uses **objects** to build systems, and it tends marry data and behavior. 
Services tend to **separate data from behavior**. 
In an SOA, the separation between data and behavior is often obvious.

**SOA**

```php
$sourceAccount = new Account(100);
$destinationAccount = new Account(0);
$service = new AccountService();
$service->transfer(100, $sourceAccount, $destinationAccount);
```

**OOP**

```php 
$sourceAccount = new Account(100);
$destinationAccount = new Account(0);
$sourceAccount->transfer(100, $destinationAccount);
```

By separating behavior from data, it's possible to build and maintain non-trivial applications over many years.
This architecture also respects the [SOLID](https://scotch.io/bar-talk/s-o-l-i-d-the-first-five-principles-of-object-oriented-design) principles to be [TDD](https://hackernoon.com/introduction-to-test-driven-development-tdd-61a13bc92d92) - friendly as much as possible.

Read more: [Services vs Objects](https://dontpaniclabs.com/blog/post/2017/10/12/services-vs-objects)

### Best practices

Think of the [SRP](http://pragmaticcraftsman.com/2006/07/single-responsibility-principle/) and give a service a "single responsibility".
What changes for the same reason should be grouped together.

Please don't prefix all service classes with `*Service`. 
A service class is not a "Manager" or "Utility" class. 
 
A service class can have several methods as long as they serve a narrow purpose. 
This also encourages you to name your classes more specifically. Instead of a "User" god-class, 
you might have a `UserCreator` class with a few methods focusing on creating a user.

> Q: Why would I change my UserCreator class?<br>
> A: Because I'm changing how I create a user<br>
> A: And not because I'm changing how I assign a user to a task. Because that's being handled by the UserTaskAssignor class.<br>

## Repositories

A [repository](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html) 
is the source of all the (database) data your application needs and mediates between the domain and data mapping layers. 
A repository improves code maintainability, testing and readability by separating **business logic** 
from **data access logic** and provides centrally managed and consistent access rules for a data source.

There are two types of repositories: collection-oriented and persistence-oriented repositories. 
In this case, we are talking about **persistence-oriented repositories**, since these are better 
suited for processing large amounts of data.
 
Each public repository method represents a query. The return values represent the result set 
of a query and can be primitive/object or list (array) of them. Database transactions must 
be handled on a higher level (service) and not within a repository.

**Quick summary:**

* Communication with the database.
* Place for the data access (query) logic.
* Uses data mapper to create domain objects
* This is no place for the business logic. Use [services](#services) for the business logic.


## Data Transfer Objects (DTO) 
  
A DTO contains only pure **data**. There is no business or domain specific logic. 
There is also no database access within a DTO. 
A service fetches data from a repository and  the repository (or the service) 
fills the DTO with data. A DTO can be used to transfer data inside or outside the domain.

**Example:**

```php
<?php

namespace App\Domain\Customer\Data;

use DateTimeImmutable;

final class CustomerData
{
    /** @var string */
    public $name;
    
    /** @var string */
    public $email;
    
    /** @var DateTimeImmutable */
    public $dateOfBirth;
}
```

**Note:** Typed class properties have been added in PHP 7.4. [Read more](https://stitcher.io/blog/typed-properties-in-php-74)

## Value Objects

Use value objects only for "small things" like Date, Money, CustomerId and as replacement for 
primitive data type like string, int, float, bool, array. 

A value object must be **immutable** and is responsible for keeping their state consistent. 

A value object should only be filled using the constructor.

Wither methods are allowed, but `setter` methods are not allowed. 

**Example:**

```php
public function withEmail(string $email): self { ... }
```

A getter method name does not contain a `get` prefix. 

**Example:**

```php
public function email(): string { return $this->email; }`. 
```

All properties must be `protected` or `private` accessed by the getter methods.

**Example:**

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
        return $this->id === $customerId->id;
    }
    
    public function __toString()
    {
        return (string)$this->id;
    }
}
```

**Read more:** [Validating Value Objects](https://kacper.gunia.me/validating-value-objects/)

## Parameter objects

If you have a lot of parameters that fit together, 
you can replace them with a parameter object. See [DTO](#data-transfer-object-dto)

## Types and enums

You should not use fixed strings and integer codes as values. Use class constants instead. 

**Example:**

```php
<?php

final class LevelType
{
    public const LOW = 1;
    public const MEDIUM = 2;
    public const HIGH = 3;
}
```
