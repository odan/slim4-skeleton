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
