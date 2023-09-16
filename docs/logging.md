---
layout: default
title: Logging
published: true
parent: Advanced
---

# Logging

## Introduction

To help you learn more about what's happening within your application, 
this Slim skeleton provides robust logging services that allow you to log messages to files, 
the system error log, and even to Slack to notify your entire team.

Under the hood, this project utilizes the [Monolog](https://github.com/Seldaek/monolog) library,
which provides support for a variety of powerful log handlers.

## Configuration

The directory for all log files is: `logs/`

The default settings are stored in `config/defaults.php`, `$settings['logger']`

## Usage

It's recommended using the `App\Factory\LoggerFactory` class to
create a custom logger for each context.

The `LoggerFactory` provides methods to generate a
file- and console based logging output.

Inject the `LoggerFactory` instance and generate a specific logger as follows:

```php
<?php

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class Example
{
    private LoggerInterface $logger;
    
    // ...

    public function __construct(LoggerFactory $loggerFactory) {
        $this->logger = $loggerFactory
            ->addFileHandler('my_log_file.log')
            ->createLogger();
    }
    
    // ...
}
```

Creating a file logger:

```php
$this->logger = $loggerFactory->addFileHandler('my_log_file.log')->createInstance();
$this->logger->info('Test');
```

Creating a console logger:

```php
$this->logger = $loggerFactory->addConsoleHandler()->createInstance();
$this->logger->info('Console test output');
```


Creating a file and console logger:

```php
$this->logger = $loggerFactory
    ->addFileHandler('my_log_file.log')
    ->addConsoleHandler()
    ->createInstance();
    
$this->logger->info('File and console output');
```

## Read more

* [Logging with Monolog](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Logging with Sentry](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
* [Error Handling](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)


