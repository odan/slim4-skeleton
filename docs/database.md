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

A [repository](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html)
is the source of all the (database) data your application needs and mediates between the domain and data mapping layers.
A repository improves code maintainability, testing and readability by separating **business logic**
from **data access logic** and provides centrally managed and consistent access rules for a data source.

There are two types of repositories: collection-oriented and persistence-oriented repositories.
In this case, I would prefer to speak of **persistence-oriented repositories**,
as they are better suited to handling large amounts of data without sacrificing simplicity.

Each public repository method represents a query. The return values represent the result set
of a query and can be primitive/object or list (array) of them. Database transactions must
be handled on a higher level (service) and not within a repository.

**Quick summary:**

* Communication with the database.
* Place for the data access (query) logic.
* Uses data mapper to create domain objects
* This is no place for the business logic.

## Query Builder

This skeleton contains [cakephp/database](https://github.com/cakephp/database) as SQL query builder.

The query builder provides a convenient, fluid interface for creating and executing database queries. It can be used to perform most database operations in your application, and works great with MySQL and MariaDB.

* [Query Builder Documentation](https://book.cakephp.org/4/en/orm/query-builder.html)
* [CakePHP Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)

It's possible to replace the existing QueryBuilder with another component as listed below:

* [Laminas Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)
* [Laravel Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)
* [Doctrine DBAL](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)
* [Cycle Query Builder](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)
* [PDO](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)
* [Yii Database](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)

## Read more

* [Amazon S3](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Amazon DynamoDB](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Apache Cassandra](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Apache Kafka](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Couchbase](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Elasticsearch](https://ko-fi.com/s/e592c10b5f) (Slim 4 eBook Vol. 2)
* [Doctrine CouchDB](https://ko-fi.com/s/e592c10b5f) (Slim 4 eBook Vol. 2)
* [Firebase Realtime Database](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [IBM DB2](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Oracle Database](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [PostgreSQL](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Microsoft SQL Server](https://ko-fi.com/s/3698cf30f3) (Slim 4 eBook Vol. 3)
* [Multiple database connections](https://ko-fi.com/s/5f182b4b22) (Slim 4 eBook Vol. 1)

