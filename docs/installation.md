---
layout: default
title: Installation
parent: Getting Started
nav_order: 1
---

# Installation

**Step 1:** Create a new project:

```shell
composer create-project odan/slim4-skeleton my-app
```

**Step 2:** Set permissions *(Linux only)*

```bash
cd my-app

sudo chown -R www-data tmp/
sudo chown -R www-data logs/

sudo chmod -R g+w tmp/
sudo chmod -R g+w logs/

chmod +x bin/console.php
```

**Step 3:** Setup database

Start the setup script and follow the instructions:

```bash
php bin/console setup
```

**Note:** The `setup` command is useful for setting up a project on 
the **local development machine**. For continuous integration 
or continuous delivery, you should use a **build and deployment pipeline**
instead.

**Step 4:** Start the internal webserver

```
composer start
```

Then navigate to: <http://localhost:8080/>

**Note:** The PHP internal webserver is designed for
application development, testing or application demonstrations.
It is not intended to be a full-featured web server. 
It should not be used on a public network.
