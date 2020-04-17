<?php

namespace App\Console;

use Psr\Container\ContainerInterface;
use Selective\Config\Configuration;
use Slim\Views\Twig;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Twig\Environment;

/**
 * Twig compiler command.
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
     * The constructor.
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
     * @return int The error code, 0 on success, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;

        $this->output->write('Compiling Twig templates... ', true);

        $settings = $this->container->get(Configuration::class)->getArray('twig');
        $twig = $this->container->get(Twig::class)->getEnvironment();

        $cachePath = (string)realpath($settings['options']['cache_path']);
        if (!$cachePath) {
            $this->output->write('<error>The twig cache path is not defined</error>', true);

            return 1;
        }

        // Compile all Twig templates into cache directory
        $this->compileTwig($twig, (array)$settings['paths'], $cachePath);

        return 0;
    }

    /**
     * Iterate over all twig templates and force compilation.
     *
     * @param Environment $twig The twig environment
     * @param array $paths The template paths
     * @param string $cachePath The output cache path
     *
     * @return void
     */
    private function compileTwig(Environment $twig, array $paths, string $cachePath): void
    {
        $filesystem = new Filesystem();
        $this->output->write(sprintf('Twig cache path: <info>%s</info>', $cachePath), true);

        // Delete old twig cache files
        if ($filesystem->exists($cachePath)) {
            $filesystem->remove($cachePath);
        }

        if (!$filesystem->exists($cachePath)) {
            $filesystem->mkdir($cachePath);
        }

        $filesystem->touch($cachePath . '/empty');

        $twig->disableDebug();
        $twig->enableAutoReload();

        // The Twig cache must be enabled
        if (!$twig->getCache()) {
            $twig->setCache($cachePath);
        }

        foreach ($paths as $path) {
            $this->compileTemplatePath($twig, $path);
        }

        $this->output->write('<info>Done</info>', true);
    }

    /**
     * Compile all templates in the given path.
     *
     * @param Environment $twig The environment
     * @param string $path The template path
     *
     * @return void
     */
    private function compileTemplatePath(Environment $twig, string $path): void
    {
        $finder = new Finder();

        $finder->files()->in($path)->filter(function (SplFileInfo $file) {
            if (!$file->isFile() || $file->getExtension() !== 'twig') {
                return false;
            }
        });

        $this->output->write(sprintf('Twig template path: <info>%s</info>', realpath($path)), true);

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $templateName = substr($file->getPathname(), strlen($path) + 1);
            $templateName = str_replace('\\', '/', $templateName);
            $this->output->write(sprintf('Compiling: %s', $templateName), true);

            $twig->loadTemplate($twig->getTemplateClass($templateName), $templateName);
        }
    }
}
