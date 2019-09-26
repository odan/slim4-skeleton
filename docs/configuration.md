## Configuration

### Application configuration 

* see `config/*`
* todo: Add more description

### Environment configuration

You may be familiar with the concept of `.env` files. 
But we are considering `.env` as harmful because: 

* people could put the file `.env` into a public available directory
* a public available `.env` file will be indexed by search engines
* `.env` files are not native and much slower then PHP files
* `.env` files are not intended to run on a production server. Many developers do it anyway.
* `vlucas/phpdotenv` is a unnecessary dependency. PHP can do it better.
* `vlucas/phpdotenv` is buggy in multi-thread PHP [(read more)](https://github.com/craftcms/cms/issues/3631)

For security and performance reasons, all secret environments variables 
are better stored in a file called: `env.php`.

**Usage**: Just create a copy of the file `config/env.example.php` and rename it to
`config/env.php`
 
> For security reasons you should NEVER EVER commit the file `env.php` into the version control system!

You can and should use a `env.php` on your testing / staging / production server too.
In this case just store the server specific `env.php` file 
one directory above the project root directory.

<hr>

Navigation: [Index](readme.md)