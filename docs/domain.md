## Domain

### Domain Services

Here is the right place for complex business logic e.g. calulation, validation, file creation etc.

This layer provides cohesive, high-level logic for related parts of an application. This layer is invoked directly by the Controllers.

The business logic should be placed in the service classes, and we should aim for a fat model layer and thin controller layer.

Please don't prefix all service classes with `*Service`. 
A service class is not a "Manager" or "Utility" class. 
Think of the [SRP](http://pragmaticcraftsman.com/2006/07/single-responsibility-principle/) and give a service a "single responsibility". 
A service classes can, and should, have several methods as long as they serve a narrow purpose. 
This also encourages you to name your classes more specifically. Instead of a "User" god-class, 
you might have a `UserRegistration` class with a few methods focusing on registration.

> Q: Why would I change my UserRegistration class?<br>
> A: Because I'm changing how I register a user<br>
> A: And not because I'm changing how I assign a user to a task. Because that's being handled by the UserTaskAssignment class.<br>

### Repositories

A distinction is actually made between collection-oriented and persistence-oriented repositories. In this case, we are talking about **persistence-oriented repositories**, since these are better suited for processing large amounts of data.

A repository is the source of all the data your application needs. It serves as an interface between the domain layer (Domain services) and the data access layer (DAO). According to Martin Fowler, "A repository is another layer above the data mapping layer. It mediates between domain and data mapping layers (data mappers)". A repository improves code maintainability, testing and readability by separating `business logic` from `data access logic` and provides centrally managed and consistent access rules for a data source. Each public repository method represents a query. The return values represent the result set of a query and can be primitive/object or list (array) of them. Database transactions must be handled on a higher level (domain service) and not within a repository.

Quick summary:

* Communication with the database.
* Place for the data access logic (query logic).
* This is no place for the business logic! Use [domain services](#domain-services) for the complex business and domain logic.


### Value Objects

Use it only for "small things" like Date, Money, CustomerId and as replacement for primitive data type like string, int, float, bool, array. A value object must be immutable and is responsible for keeping their state consistent [Read more](https://kacper.gunia.me/validating-value-objects/). A value object should only be filled using the constructor, classic `setter` methods are not allowed. Wither methods are allowed. Example: `public function withEmail(string $email): self { ... }`. A getter method name does not contain a `get` prefix. Example: `public function email(): string { return $this->email; }`. All properties must be `protected` or `private` accessed by the getter methods.

### Data Transfer Object (DTO) 
  
A DTO contains only pure **data**. There is no business or domain specific logic, only simple validation logic. There is also no database access within a DTO. A service fetches data from a repository and  the repository (or the service) fills the DTO with data. A DTO can be used to transfer data inside or outside the domain.

### Parameter object

If you have a lot of parameters that fit together, you can replace them with a parameter object. [Read more](https://refactoring.com/catalog/introduceParameterObject.html)

### Types and enums

Don't use strings or fix integer codes as values. Instead use public class constants.

<hr>

Navigation: [Index](readme.md)
