---
layout: default
title: Console
parent: Advanced
---

# Console

## Installation

You'll need to install the Symfony Console component to add command-line capabilities to your project. 

Use Composer to do this:

```
composer require symfony/console
```

## Creating a console command

Create a new command class, e.g. `src/Console/ExampleCommand.php` and copy/paste this content:

```php
<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExampleCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();

        $this->setName('example');
        $this->setDescription('A sample command');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(sprintf('<info>Hello, World!</info>'));

        // The error code, 0 on success
        return 0;
    }
}
```

## Register the Console Application

To integrate the Console application with your application, 
you'll need to register it. Create a file, e.g., `bin/console.php`, and add the following code

```php
<?php

use App\Console\ExampleCommand;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

require_once __DIR__ . '/../vendor/autoload.php';

$env = (new ArgvInput())->getParameterOption(['--env', '-e'], 'dev');

if ($env) {
    $_ENV['APP_ENV'] = $env;
}

/** @var ContainerInterface $container */
$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/../config/container.php')
    ->build();

try {
    /** @var Application $application */
    $application = $container->get(Application::class);
    
    // Register your console commands here
    $application->add($container->get(ExampleCommand::class));
    
    exit($application->run());
} catch (Throwable $exception) {
    echo $exception->getMessage();
    exit(1);
}

```

Set permissions:

```php
chmod +x bin/console.php
```

To start to example command, run:

``` bash
php bin/console.php example
```

The output:

```
Hello, World!
```

## Console Commands

To list all available commands, run:

``` bash
php bin/console.php
```

## Read more

* [Symfony Console Commands](https://symfony.com/doc/current/console.html)
* [Console](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
