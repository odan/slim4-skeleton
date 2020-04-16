---
layout: default
title: Installation
nav_order: 2
has_children: true
---

# Manual Setup

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

3.1 Create a new database for development

```bash
mysql -e 'CREATE DATABASE IF NOT EXISTS slim_skeleton_dev CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
```

3.2 Create a new database for integration tests

```bash
mysql -e 'CREATE DATABASE IF NOT EXISTS slim_skeleton_int CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'
```

3.3 Copy the file: `config/env.example.php` to `config/env.php`.

```bash
cp config/env.example.php config/env.php
```

3.4 Change the connection configuration in `config/env.php`:

```php
// Database
$settings['db']['database'] = 'test';
$settings['db']['username'] = 'root';
$settings['db']['password'] = '';
```

3.5. Run all of the available migrations:

```shell
composer migrate
```

**Step 4:** Run it

Open `http://localhost/{my-app}` in your browser
