---
layout: default
title: Composer
parent: Installation
nav_order: 1
---

# Installation using Composer

Run this command from the directory in which you want to install your new 
Slim Framework application.

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

**Step 3:** Database setup

Create a new database for development

```bash
mysql -e 'CREATE DATABASE IF NOT EXISTS slim_skeleton_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
```

Create a new database for integration tests

```bash
mysql -e 'CREATE DATABASE IF NOT EXISTS slim_skeleton_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
```

**Step 4:** Configuration

Copy the file: `config/env.example.php` to `config/env.php`.

```bash
cp config/env.example.php config/env.php
```

Change the connection configuration in `config/env.php`:

```php
// Database
$settings['db']['database'] = 'test';
$settings['db']['username'] = 'root';
$settings['db']['password'] = '';
```

Run all the available migrations:

```shell
composer migration:migrate
```

**Step 5:** Run it

Open `http://localhost/{my-app}` in your browser

If you use the PHP internal web server, you can use this command:

```
cd {project-path/}
php -S localhost:8080 -t public
```

Then navigate to: `http://localhost:8080/`
