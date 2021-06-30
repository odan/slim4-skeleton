---
layout: default
title: Console
parent: Advanced
---

# Console

## Composer scripts

To list all composer scripts, run:

```
composer list
```

## Commands

The default console executable is: `bin/console.php`

The console command directory is: `src/Console` 

To start the console and list all available commands, run:

``` bash
php bin/console.php
```

## Creating a console command

Create a new command class, e.g. `src/Console/ExampleCommand.php` and copy/paste this content:

```php
<?php

namespace App\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command.
 */
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
        $output->writeln(sprintf('<info>Hello, console</info>'));

        // The error code, 0 on success
        return 0;
    }
}
```

To register a new command you have to open `config/defaults.php` 
and add a new array entry to `$settings['commands']`.

```php
$settings['commands'] = [
    // ...
    \App\Console\ExampleCommand::class,
];
```

To start to example command, run:

``` bash
php bin/console.php example
```

The output:

```
Hello, console
```

Read more: [Symfony Console Commands](https://symfony.com/doc/current/console.html)

## Managing Locks

Locks are used to guarantee exclusive access to some shared resource. 

A lock can be used to ensure that the server starts only one 
specific cronjob or console command at the same time.

* [The Lock Component](https://symfony.com/doc/current/components/lock.html)

## Read more

* [Slim 4 - Console](https://odan.github.io/2021/06/23/slim-console.html)
