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

## Console Commands

The default console executable is: `bin/console.php`

The default console command class directory is: `src/Console`

To start the console and list all available commands, run:

``` bash
php bin/console
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
php bin/console example
```

The output:

```
Hello, World!
```

Read more:

* [Symfony Console Commands](https://symfony.com/doc/current/console.html)
* [Console](https://ko-fi.com/s/5f182b4b22) (Slim 4 - eBook Vol. 1)
