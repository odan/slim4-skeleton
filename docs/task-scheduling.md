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

When using the scheduler, 
only a single [crontab](https://help.ubuntu.com/community/CronHowto)
entry is needed on your server.

Add a new entry to your crontab to run `bin/cronjob.php` every minute.

Your server crontab could now look something like:

```
* * * * * /usr/bin/php /var/www/example.com/bin/cronjob.php  1>> /dev/null 2>&1
```

Your scheduler is up and running, now you can add your jobs without
worrying anymore about the crontab.

## Defining Schedules

These libraries can be used to define and execute cronjob tasks.
There are more, of course.

* <https://github.com/Cron/Cron>
* <https://github.com/peppeocchi/php-cron-scheduler>
* <https://github.com/jobbyphp/jobby>

## Managing Locks

Locks are used to guarantee exclusive access to some shared resource.

A lock can be used to ensure that the server starts only one
specific cronjob or console command at the same time.

* [The Lock Component](https://symfony.com/doc/current/components/lock.html)
