---
layout: default
title: Deployment
nav_order: 16
---

# Deployment

## Server Setup

Make sure the apache [DocumentRoot](https://httpd.apache.org/docs/2.4/en/mod/core.html#documentroot) points to the `public` path, e.g. `/var/www/example.com/htdocs/public`

* Create a directory: `/var/www/example.com`
* Create a directory: `/var/www/example.com/htdocs`
* Upload a custom `env.php` file to `/var/www/example.com/env.php`
* Upload `config/deploy.php` to `/var/www/example.com/deploy.php`

## Building

To build a new artifact (ZIP file), run:

``` bash
$ composer build
```

The artifact output directory is: `build/`

### Deployment

To deploy the artifact on test, staging and production server, just upload
the zip file with a SFTP client onto your server directory, e.g. `/var/www/example.com`.

Then extract the artifact into the `htdocs/` sub-directory and run the migrations. 

It's recommended to use `deploy.php` script for this task:

* Upload the artifact from `build/my_app_*.zip` to `/var/www/example.com/`
* Then run `sudo php deploy.php my_app_*.zip`

**Example:**

```bash
$ cd /var/www/example.com
$ sudo php deploy.php my_app_2019-01-29_235044.zip
```

Read more: [Continuous Delivery](https://www.amazon.de/dp/B003YMNVC0)
