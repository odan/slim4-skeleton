---
layout: default
title: Cronjobs
nav_order: 17
---

# Cronjobs

The [Jobby](https://github.com/jobbyphp/jobby) cron job manager allows you to define your 
command schedule within PHP itself. When using the scheduler, 
only a single [crontab](https://help.ubuntu.com/community/CronHowto) entry is needed on your server. 

To install Jobby, please follow the [installation](https://github.com/jobbyphp/jobby#getting-started) instructions.

Create a new file: `bin/jobby.php`

To invoke the `example` command in `src/Console/ExampleCommand.php` add this job into `bin/jobby.php`:

```php
<?php

use Jobby\Jobby;

require_once __DIR__ . '/../vendor/autoload.php';

$jobby = new Jobby();

// Every job has a name
$jobby->add('ExampleCommand', [
    // Run a shell command
    'command' => 'php ' . __DIR__ . '/console.php example',
    // This schedule runs every minute.
    'schedule' => '* * * * *',
    'enabled'  => true,
    'output'   => __DIR__ . '/../logs/example_command.log',
]);

$jobby->run();

```

To start the cron job manager manually, run:

```
php bin/jobby.php
```
