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
        $this->setDescription('A console command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Hello, World!</info>');

        return 0;
    }
}
