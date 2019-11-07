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

Read more: **[Query Builder Documentation](https://book.cakephp.org/3.0/en/orm/query-builder.html)**

## Migrations

This skeleton provides a [Phinx](https://phinx.org/) console access to create database migrations.

**Some basics:**

* **Migrations** are for moving from schema to schema (and back, if possible).
* **Seeding** is the initial data setup. If you aren't at an initial (seed) state, you need a migration to change the data.
* **Fixtures** are data for testing purposes.

### Generating a migration from a diff automatically

```bash
$ composer generate-migration
```

You an specify a migration name by adding the `--name` parameter.

**Note:** [Composer](https://getcomposer.org/) requires double dashes (`--`) to separate arguments. 

```bash
$ composer generate-migration -- --name AddTableCustomers
```

### Creating a blank database migration

```bash
$ composer create-migration UpdateArticleFixtures
```

Read more: **[Phinx Documentation](http://docs.phinx.org/en/latest/)**

## Update schema

Update the database schema with this command:

```bash
$ composer migrate
```

If [Composer](https://getcomposer.org/) is not installed on the target server, the following command can be used:

```bash
$ vendor/bin/phinx migrate -c config/phinx.php
```

## Data Seeding

All seeds are stored in the directory: `resources/seeds/`

To populate the database with data for testing and experimenting, run:

```bash
$ composer seed-database
```

To start the seeder directly, run this command:

```bash
$ vendor/bin/phinx seed:run -c config/phinx.php
```

## Resetting the database

The command `refresh-database` will rollback all migrations, 
migrate the database and seed the data. 

**Attention: All data will be lost from the database.**

```
$ composer refresh-database
```
