<?php

use App\Factory\LoggerFactory;
use App\Middleware\TranslatorMiddleware;
use Cake\Database\Connection;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Odan\Twig\TwigTranslationExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathDetector;
use Selective\Config\Configuration;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Loader\FilesystemLoader;

return [
    // Application settings
    Configuration::class => static function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    App::class => static function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Set the base path to run the app in a subdirectory.
        // This path is used in urlFor().
        $basePath = (new BasePathDetector($_SERVER))->getBasePath();
        $app->setBasePath($basePath);

        $config = $container->get(Configuration::class);
        $routeCacheFile = $config->findString('router.cache_file');
        if ($routeCacheFile) {
            $app->getRouteCollector()->setCacheFile($routeCacheFile);
        }

        return $app;
    },

    // For the HtmlResponder
    ResponseFactoryInterface::class => static function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return $app->getResponseFactory();
    },

    // The Slim RouterParser
    RouteParserInterface::class => static function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    // The logger factory
    LoggerFactory::class => static function (ContainerInterface $container) {
        return new LoggerFactory($container->get(Configuration::class)->getArray('logger'));
    },

    // Twig templates
    Twig::class => static function (ContainerInterface $container) {
        $config = $container->get(Configuration::class);
        $twigSettings = $config->getArray('twig');

        $twig = new Twig($twigSettings['path'], [
            'cache' => $twigSettings['cache_enabled'] ? $twigSettings['cache_path'] : false,
        ]);

        $loader = $twig->getLoader();
        if ($loader instanceof FilesystemLoader) {
            $loader->addPath($config->getString('public'), 'public');
        }

        $environment = $twig->getEnvironment();

        // Add relative base url
        $basePath = $container->get(App::class)->getBasePath();
        $environment->addGlobal('base_path', $basePath . '/');

        // Add Twig extensions
        $twig->addExtension(new TwigTranslationExtension());

        $twig->addExtension(new WebpackExtension(
            $config->getString('public') . '/assets/manifest.json',
            $basePath . '/assets/',
            $basePath . '/assets/'
        ));

        return $twig;
    },

    // Translation
    Translator::class => static function (ContainerInterface $container) {
        $settings = $container->get(Configuration::class)->getArray('locale');

        $translator = new Translator(
            $settings['locale'],
            new MessageFormatter(new IdentityTranslator()),
            $settings['cache'],
            $settings['debug']
        );

        $translator->addLoader('mo', new MoFileLoader());

        // Set translator instance
        __($translator);

        return $translator;
    },

    TranslatorMiddleware::class => static function (ContainerInterface $container) {
        $settings = $container->get(Configuration::class)->getArray('locale');
        $localPath = $settings['path'];
        $translator = $container->get(Translator::class);

        return new TranslatorMiddleware($translator, $localPath);
    },

    Connection::class => static function (ContainerInterface $container) {
        return new Connection($container->get(Configuration::class)->getArray('db'));
    },

    PDO::class => static function (ContainerInterface $container) {
        $db = $container->get(Connection::class);
        $db->getDriver()->connect();

        return $db->getDriver()->getConnection();
    },

    ValidationExceptionMiddleware::class => static function (ContainerInterface $container) {
        $factory = $container->get(ResponseFactoryInterface::class);

        return new ValidationExceptionMiddleware($factory, new JsonEncoder());
    },
];
