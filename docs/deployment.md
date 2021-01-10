---
layout: default
title: Deployment
nav_order: 16
---

# Deployment

A deployment artifact (or a build ) is the application code as it runs on production: 
compiled, built, bundled, minified, optimized and so on.
 
## Requirements

* [Apache ant](https://ant.apache.org) to create deployment artifacts (build)
* [Java 8 runtime](https://www.java.com/en/download/manual.jsp)

## Installation

* Download the latest binary of [Apache Ant](https://ant.apache.org/bindownload.cgi)
* Extract the zip file to `c:\ant`
* Add the `c:\ant\bin` directory to your `%PATH%` environment variable
* Make sure JDK is installed, and `JAVA_HOME` is configured as environment variable.
* Read more: [How to install Apache Ant on Windows](https://mkyong.com/ant/how-to-install-apache-ant-on-windows/)

## Building

Make sure that the project is already versioned in a Git repository.

To build a new artifact (ZIP file), run:

``` bash
$ composer build
```

The artifact output directory is: `build/`

## Server Setup

Ensure that the apache [DocumentRoot](https://httpd.apache.org/docs/2.4/en/mod/core.html#documentroot) 
points to the `public/` path, e.g. `/var/www/example.com/htdocs/public`

* Create a directory: `/var/www/example.com`
* Create a sub-directory: `/var/www/example.com/htdocs`
* Upload a custom `env.php` file to `/var/www/example.com/env.php`
* Upload the file `bin/deploy.php` to `/var/www/example.com/deploy.php`

## Deployment

To deploy the artifact on a server you can upload the ZIP file with a [SFTP client](https://winscp.net) 
from `build/my_app_*.zip` to `/var/www/example.com/`

Then extract the artifact to the `htdocs/` sub-directory using the `deploy.php` script.

**Usage:**

```bash
cd /var/www/example.com
sudo php deploy.php my_app_2021-01-01_235044.zip
```

If you still need more features, then you may try [Deployer](https://deployer.org/) - a deployment tool for PHP.

**Read more** 

* [Continuous Delivery](https://www.amazon.com/dp/B003YMNVC0?tag=28031982-21) (Amazon.com)
* [Continuous Delivery](https://www.amazon.de/dp/B003YMNVC0?tag=28031982-21) (Amazon.de)
