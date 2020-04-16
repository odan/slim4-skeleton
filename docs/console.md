---
layout: default
title: Console
nav_order: 17
---

# Console

## Commands

The default console executable is: `bin/console.php`

The console command directory is: `src/Console` 

To start the cli, run:

``` bash
composer cli
```

or directly:

``` bash
php bin/console.php
```

## Available commands

* `compile-twig` - To compile Twig templates
* `dump-schema` - Generates a schema.sql from the schema data source.

## Creating a console command

Create a new command class, e.g. `src/Console/ExampleCommand.php` and copy/paste this content:

```php
<?php

namespace App\Console;

use PDO;
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
composer cli example
```

The output:

```
Hello, console
```

Read more: [Symfony Console Commands](https://symfony.com/doc/current/console.html)

## Cronjobs  

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
