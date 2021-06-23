---
layout: default
title: Database
nav_order: 6
---

# Database

## Database configuration

You can configure the database settings for each server environment.

The default settings are stored in `config/defaults.php`, `$settings['db']` 

## Query Builder

This skeleton contains [cakephp/database](https://github.com/cakephp/database) as SQL query builder.

The query builder provides a convenient, fluid interface for creating and executing database queries. It can be used to perform most database operations in your application, and works great with MySQL and MariaDB.

* **[Query Builder Documentation](https://book.cakephp.org/4/en/orm/query-builder.html)**
* [Slim 4 - CakePHP Query Builder](https://odan.github.io/2019/12/03/slim4-cakephp-query-builder.html)

It's possible to replace the existing QueryBuilder with another component as listed below:

* [Laminas Query Builder](https://odan.github.io/2019/12/01/slim4-laminas-db-query-builder-setup.html)
* [Laravel Query Builder](https://odan.github.io/2019/12/03/slim4-eloquent.html)
* [Doctrine DBAL](https://odan.github.io/2019/12/05/slim4-doctrine-dbal.html)
* [PDO](https://odan.github.io/2017/01/07/basic-crud-operations-with-pdo.html)

## Multitenancy

The concept from this article can also be applied to all other QueryBuilders:

* [Multiple database connections](https://odan.github.io/2020/04/05/slim4-multiple-pdo-database-connections.html)

## Migrations

This skeleton provides a [Phoenix](https://github.com/lulco/phoenix/) 
console access to create database migrations.

**Some basics:**

* **Migrations** are for moving from schema to schema (and back, if possible).
* **Seeding** is the initial data setup. If you aren't at an initial (seed) state, you need a migration to change the data.
* **Fixtures** are data for testing purposes.

To create a new migration class, run:

```
php vendor/bin/phoenix create UpdateArticleFixtures
```

To generate a migration diff from another database, run:

```
php vendor/bin/phoenix diff --source=local2 --target=local --migration=NameOfMigration
```

*Make sure that you have a second local database to create the diff from. See `config/defaults.php`.* 

To executes all available migrations, run:

```
php vendor/bin/phoenix migrate
```

To rollback the last executed migration, run:

```
php vendor/bin/phoenix rollback
```

To list the already executed migrations, run:

```
php vendor/bin/phoenix status
```

There are more commands available. Please consult the **[Phoenix Documentation](https://github.com/lulco/phoenix/)**.

## Schema Dump

The `composer schema:dump` command dumps the current state of your schema to 
a `resources/schema/schema.sql` file.

```
composer schema:dump
```

When you run integrations (database) tests, this `schema.sql` file will be loaded into the database. 
This means that effectively this schema file would typically only ever be used during local 
development or during CI testing. In production, you would typically already have migrations 
that have run in the past.

This feature solves two problems. First, it relieves developers from having a huge migrations 
directory full of files they no longer need. Second, loading a single schema file is quicker 
than running hundreds of migrations for each test class in your applications, 
so your tests can run much faster when using a schema.

## More Resources

* [Designing a database](https://odan.github.io/2017/01/17/designing-a-database.html)
