---
layout: default
title: Task Scheduling
parent: Advanced
---

# Task Scheduling

## Cronjobs

In the past, you may have written a cron configuration entry for each task you 
needed to schedule on your server. However, this can quickly become a 
pain because your task schedule is no longer in source control and 
you must SSH into your server to view your existing cron entries 
or add additional entries

The [Jobby](https://github.com/jobbyphp/jobby) command scheduler 
offers a nice approach to managing scheduled tasks on your server.
The scheduler allows you to expressively define your command schedule within 
your application itself. When using the scheduler, 
only a single [crontab](https://help.ubuntu.com/community/CronHowto)
entry is needed on your server.

## Installation

To install Jobby, please follow the 
[installation](https://github.com/jobbyphp/jobby#getting-started) instructions.

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
