---
layout: default
title: Database
nav_order: 6
---

# Database

## Database configuration

You can configure the database settings for each server environment.

The default settings are stored in `config/defaults.php`, `$settings['db']` 


## Repositories

A [repository](https://designpatternsphp.readthedocs.io/More/Repository/README.html) 
provides an abstraction layer between the data access logic and the business logic 
of an application, allowing data operations to be decoupled from the specifics 
of the underlying database or data source.

There are two types of repositories: collection-oriented and persistence-oriented repositories.

A collection-oriented repository treats in-memory objects as part of a collection, 
emphasizing behaviors like adding, removing, or querying objects within that collection. 
It often abstracts the underlying data source as a simple in-memory collection. 
In contrast, a persistence-oriented repository focuses on the storage, retrieval, 
and deletion of objects in a persistent data store, such as a database, 
and emphasizes the persistence lifecycle and operations specific to the 
underlying storage mechanism.

This project employs **persistence-oriented** repositories for efficient 
large data handling  without the complexity of the [Unit of Work](https://en.wikipedia.org/wiki/Unit_of_work) pattern.
Handle database **transactions** at the service level, not within the repository.

Every public repository method represents a query, 
returning either a primitive/object or an array 
of them as the result set.

**Quick summary:**

* Communication with the database.
* Place for the data access (query) logic.
* Uses data mapper to create domain objects
* This is no place for the business logic.

## Query Builder

This skeleton contains [cakephp/database](https://github.com/cakephp/database) as SQL query builder.

The query builder provides a convenient, fluid interface for creating and executing database queries. It can be used to perform most database operations in your application, and works great with MySQL and MariaDB.

* [Query Builder Documentation](https://book.cakephp.org/4/en/orm/query-builder.html)
* [CakePHP Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)

It's possible to replace the existing QueryBuilder with another component as listed below:

* [Laminas Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Laravel Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Doctrine DBAL](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Cycle Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [PDO](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Yii Database](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)

## Read more

* [Amazon S3](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Amazon DynamoDB](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Apache Cassandra](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Apache Kafka](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Couchbase](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Elasticsearch](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [Doctrine CouchDB](https://ko-fi.com/s/e592c10b5f) (Slim 4 - eBook Vol. 2)
* [Firebase Realtime Database](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [IBM DB2](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Oracle Database](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [PostgreSQL](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Microsoft SQL Server](https://ko-fi.com/s/3698cf30f3) (Slim 4 - eBook Vol. 3)
* [Multiple database connections](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)

