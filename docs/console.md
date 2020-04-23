---
layout: default
title: Console
nav_order: 17
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
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The container
     * @param string|null $name The name
     */
    public function __construct(ContainerInterface $container, ?string $name = null)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    /**
     * Configure.
     *
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('example');
        $this->setDescription('A sample command');
    }

    /**
     * Execute command.
     *
     * @param InputInterface $input The input
     * @param OutputInterface $output The output
     *
     * @return int The error code, 0 on success
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(sprintf('<info>Hello, console</info>'));

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
