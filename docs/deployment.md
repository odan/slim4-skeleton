---
layout: default
title: Deployment
nav_order: 16
---

# Deployment

## Server Setup

Ensure that the apache [DocumentRoot](https://httpd.apache.org/docs/2.4/en/mod/core.html#documentroot) 
points to the `public/` path, e.g. `/var/www/example.com/htdocs/public`

* Create a directory: `/var/www/example.com`
* Create a directory: `/var/www/example.com/htdocs`
* Upload a custom `env.php` file to `/var/www/example.com/env.php`
* Upload `config/deploy.php` to `/var/www/example.com/deploy.php`

Read more:

* [Setting up permissions for apache var/www/html](https://odan.github.io/2019/02/17/correct-owner-and-permissions-of-var-www-html.html)

## Building

To build a new artifact (ZIP file), run:

``` bash
$ composer build
```

The artifact output directory is: `build/`

### Deployment

To deploy the artifact on a server you can upload the ZIP file with a [SFTP client](https://winscp.net) 
from `build/my_app_*.zip` to `/var/www/example.com/`

Then extract the artifact to the `htdocs/` sub-directory and perform the migrations.

```bash
# extract artifact to release directory
sudo unzip my_app.zip -d release/

# backup old version
mv htdocs/ htdocs-old/

# copy new version
mv release/ htdocs/

# set permissions
sudo chmod -R 775 htdocs/tmp/
sudo chmod -R 775 htdocs/logs/

# run migrations
sudo vendor/bin/phinx migrate -c config/phinx.php
```

It's recommended to use the `deploy.php` script for this task.

**Example:**

```bash
$ cd /var/www/example.com
$ sudo php deploy.php my_app_2019-01-29_235044.zip
```

Read more: [Continuous Delivery](https://www.amazon.de/dp/B003YMNVC0)
