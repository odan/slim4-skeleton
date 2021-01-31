---
layout: default
title: Logging
published: true
parent: Advanced
---

# Logging

## Introduction

This project already contains Monolog as logging component.

It's recommended using the `App\Factory\LoggerFactory` class to 
create a custom logger for each context.

The `LoggerFactory` provides methods to generate a 
file- and console based logging output.

## Usage

Inject the `LoggerFactory` instance and generate a specific logger as follows:

```php
<?php

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class Example
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
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

* [Logging with Monolog](https://odan.github.io/2020/05/25/slim4-logging.html)
* [Logging with Sentry](https://odan.github.io/2020/06/18/slim4-sentry.html)
* [Error Handling](https://odan.github.io/2020/05/27/slim4-error-handling.html)

