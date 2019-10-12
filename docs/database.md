## Database

### Database configuration

* You may configure the database settings per server environment.
* The global default settings are stored in `config/defaults.php` > `$settings['db']` 

### Query Builder

This application comes with [cakephp/database](https://github.com/cakephp/database) as SQL query builder.

The database query builder provides a convenient, fluent interface to creating and running database queries. It can be used to perform most database operations in your application, and works great with MySQL and MariaDB.

For more details how to build queries read the **[documentation](https://book.cakephp.org/3.0/en/orm/query-builder.html)**.

### Migrations

This skeleton project provides console access for **[Phinx](https://phinx.org/)** to 
create database migrations. 

**Some basics:**

`Migrations` are for moving from schema to schema (and back, if possible).
`Seeding` is the initial data setup. If you aren't at an initial (seed) state, you need a migration to change data.
`Fixtures` are data for testing purposes.

#### Generating a migration from a diff automatically

```bash
$ composer generate-migration
```

You an specify a migration name by adding the `--name` parameter.

**Note:** Composer requires double dashes (`--`) to separate arguments. 

```bash
$ composer generate-migration -- --name AddTableCustomers
```

#### Creating a blank database migration

```bash
$ composer create-migration UpdateArticleFixtures
```

For more details how to create and manage migrations read the 
[Phinx](http://docs.phinx.org/en/latest/) documentation.

### Update schema

Updating the database schema with this shorthand command:

```bash
$ composer migrate
```

If `composer` is not installed on the target server, the following command can be used:

```bash
$ vendor/bin/phinx migrate -c config/phinx.php
```

### Data Seeding

To populate the database with data for testing and experimenting with the code run:

```bash
$ composer seed-database
```

To start the seeder directly, run this command:

```bash
$ vendor/bin/phinx seed:run -c config/phinx.php
```

You may add more seeds under the directory: `resources\seeds\DataSeed`.

### Resetting the database

The command `refresh-database` will rollback all migrations, 
migrate the database and seed the data. 

**Attention: All data will be lost from the database.**

```
$ composer refresh-database
```

<hr>

Navigation: [Index](readme.md)

