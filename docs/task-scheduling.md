---
layout: default
title: Task Scheduling
parent: Advanced
---

# Task Scheduling

## Introduction to Cronjob Management

Managing scheduled tasks on your server 
involved manually editing the cron configuration for each 
task. This method is inconvenient since it lacks 
source control and requires SSH access to the 
server for changes. However, using a task scheduler 
simplifies this by requiring just one crontab entry.

### Quick Start: Setting up the Scheduler

To set up a task scheduler, you only need to add a single crontab entry. 
To run `bin/cronjob.php` every minute, append the following 
line to your server's crontab:

```bash
* * * * * /usr/bin/php /var/www/example.com/bin/cronjob.php 1>> /dev/null 2>&1
```

Now your scheduler is operational, and you can add new jobs 
without modifying the crontab.

## Recommended Libraries for Cronjob Scheduling

Here are some recommended libraries to define and manage your scheduled tasks:

* [Cron/Cron](https://github.com/Cron/Cron)
* [PHP Cron Scheduler](https://github.com/peppeocchi/php-cron-scheduler)
* [Jobby](https://github.com/jobbyphp/jobby)

## Resource Locking

Resource locks ensure exclusive access to a shared resource, 
preventing multiple instances of a cronjob or console command 
from running simultaneously.

For implementing resource locks, 
consider using [The Lock Component](https://symfony.com/doc/current/components/lock.html)
by Symfony.

By employing the techniques outlined above, 
you can easily manage and coordinate your scheduled tasks.
