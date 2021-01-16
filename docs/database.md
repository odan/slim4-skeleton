---
layout: default
title: Database
nav_order: 12
---

# Database

## Database configuration

You can configure the database settings for each server environment.

The default settings are stored in `config/defaults.php`, `$settings['db']` 

## Query Builder

This skeleton contains [cakephp/database](https://github.com/cakephp/database) as SQL query builder.

The query builder provides a convenient, fluid interface for creating and executing database queries. It can be used to perform most database operations in your application, and works great with MySQL and MariaDB.

Read more: **[Query Builder Documentation](https://book.cakephp.org/4/en/orm/query-builder.html)**

## Migrations

This skeleton provides a [Phinx](https://phinx.org/) console access to create database migrations.

**Some basics:**

* **Migrations** are for moving from schema to schema (and back, if possible).
* **Seeding** is the initial data setup. If you aren't at an initial (seed) state, you need a migration to change the data.
* **Fixtures** are data for testing purposes.

### Generating a migration from a diff automatically

```bash
$ composer migration:diff
```

You can specify a migration name by adding the `--name` parameter.

**Note:** [Composer](https://getcomposer.org/) requires double dashes (`--`) to separate arguments. 

```bash
$ composer migration:diff -- --name AddTableCustomers
```

### Creating a blank database migration

```bash
$ composer migration:create UpdateArticleFixtures
```

Read more: **[Phinx Documentation](http://docs.phinx.org/)**

## Update schema

Update the database schema with this command:

```bash
$ composer migration:migrate
```

If [Composer](https://getcomposer.org/) is not installed on the target server, 
the following command can be used:

```bash
$ vendor/bin/phinx migrate -c config/phinx.php
```

## Data Seeding

All seeds are stored in the directory: `resources/seeds/`

To populate the database with data for testing and experimenting, run:

Linux:

```bash
$ vendor/bin/phinx seed:run -c config/phinx.php
```

Windows:

```bash
call vendor/bin/phinx seed:run -c config/phinx.php
```

## Schema Dump

The `composer dump-schema` command dumps the current state of your schema to 
a `resources/schema/schema.sql` file.

```
$ composer migration:dump
```

When you run integrations (database) tests, this `schema.sql` file will be loaded into the database. 
This means that effectively this schema file would typically only ever be used during local 
development or during CI testing. In production, you would typically already have migrations 
that have run in the past.

This feature solves two problems. First, it relieves developers from having a huge migrations 
directory full of files they no longer need. Second, loading a single schema file is quicker 
than running hundreds of migrations for each test class in your applications, 
so your tests can run much faster when using a schema.
