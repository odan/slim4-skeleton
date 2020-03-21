<?php

use App\Factory\LoggerFactory;
use App\Middleware\TranslatorMiddleware;
use Cake\Database\Connection;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Odan\Session\MemorySession;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Odan\Twig\TwigTranslationExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Selective\Config\Configuration;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Factory\UriFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigMiddleware;
use Slim\Views\TwigRuntimeLoader;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Loader\FilesystemLoader;

return [
    // Application settings
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $config = $container->get(Configuration::class);
        $routeCacheFile = $config->findString('router.cache_file');
        if ($routeCacheFile) {
            $app->getRouteCollector()->setCacheFile($routeCacheFile);
        }

        return $app;
    },

    // For the responder
    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    // The Slim RouterParser
    RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    // The logger factory
    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get(Configuration::class)->getArray('logger'));
    },

    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer($container->get(App::class), Twig::class);
    },

    // Twig templates
    Twig::class => function (ContainerInterface $container) {
        $config = $container->get(Configuration::class);
        $twigSettings = $config->getArray('twig');

        $twig = Twig::create($twigSettings['path'], [
            'cache' => $twigSettings['cache_enabled'] ? $twigSettings['cache_path'] : false,
        ]);

        $loader = $twig->getLoader();
        if ($loader instanceof FilesystemLoader) {
            $loader->addPath($config->getString('public'), 'public');
        }

        // Add extensions
        $twig->addExtension(new TwigTranslationExtension());
        $twig->addExtension(new WebpackExtension(
            $config->getString('public') . '/assets/manifest.json',
            'assets/',
            'assets/'
        ));

        // Add the Twig extension only we run the app from the command line / cron job,
        // but not when phpunit tests are running.
        if ((PHP_SAPI === 'cli' || PHP_SAPI === 'cgi-fcgi') && !defined('PHPUNIT_TEST_SUITE')) {
            $app = $container->get(App::class);
            $routeParser = $app->getRouteCollector()->getRouteParser();
            $uri = (new UriFactory())->createUri('http://localhost');

            $runtimeLoader = new TwigRuntimeLoader($routeParser, $uri);
            $twig->addRuntimeLoader($runtimeLoader);
            $twig->addExtension(new TwigExtension());
        }

        return $twig;
    },

    SessionInterface::class => function (ContainerInterface $container) {
        $settings = $container->get(Configuration::class)->getArray('session');

        if (PHP_SAPI === 'cli') {
            $session = new MemorySession();
        } else {
            $session = new PhpSession();
        }
        $session->setOptions($settings);

        return $session;
    },

    // Translation
    Translator::class => function (ContainerInterface $container) {
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

    TranslatorMiddleware::class => function (ContainerInterface $container) {
        $settings = $container->get(Configuration::class)->getArray('locale');
        $localPath = $settings['path'];
        $translator = $container->get(Translator::class);
        $session = $container->get(SessionInterface::class);

        return new TranslatorMiddleware($translator, $session, $localPath);
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return new BasePathMiddleware($app);
    },

    // Database connection
    Connection::class => function (ContainerInterface $container) {
        return new Connection($container->get(Configuration::class)->getArray('db'));
    },

    PDO::class => function (ContainerInterface $container) {
        $db = $container->get(Connection::class);
        $driver = $db->getDriver();
        $driver->connect();

        return $driver->getConnection();
    },

    ValidationExceptionMiddleware::class => function (ContainerInterface $container) {
        $factory = $container->get(ResponseFactoryInterface::class);

        return new ValidationExceptionMiddleware($factory, new JsonEncoder());
    },
];
