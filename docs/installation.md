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

sudo chmod -R 760 tmp/
sudo chmod -R 760 logs/

chmod +x bin/console.php
```

**Step 3:** Setup database

Start the setup script and follow the instructions:

```bash
php bin/console.php setup
```

**Step 4:** Start the internal webserver

```
composer start
```

Then navigate to: <http://localhost:8080/>
