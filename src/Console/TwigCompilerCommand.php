<?php

namespace App\Console;

use Exception;
use Odan\Twig\TwigCompiler;
use Psr\Container\ContainerInterface;
use Selective\Config\Configuration;
use Slim\Views\Twig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command.
 */
final class TwigCompilerCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var OutputInterface
     */
    private $output;

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

        $this->setName('compile-twig');
        $this->setDescription('Compile Twig templates');
    }

    /**
     * Execute command.
     *
     * @param InputInterface $input The input
     * @param OutputInterface $output The output
     *
     * @throws Exception
     *
     * @return int integer 0 on success, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;

        return $this->compileTwig();
    }

    /**
     * Execute command.
     *
     * @throws Exception
     *
     * @return int integer 0 on success, or an error code
     */
    private function compileTwig(): int
    {
        $this->output->write('Compiling Twig templates... ', true);

        $twig = $this->container->get(Twig::class);
        $settings = $this->container->get(Configuration::class)->getArray('twig');
        $cachePath = $settings['cache_path'];
        $this->output->write(sprintf('Cache path: <info>%s</info>', $cachePath), true);

        // Compile all Twig templates into cache directory
        $compiler = new TwigCompiler($twig->getEnvironment(), $cachePath, true);
        $compiler->compile();

        $this->output->write('<info>Done</info>', true);

        return 0;
    }
}
