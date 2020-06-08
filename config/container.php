<?php

use App\Factory\LoggerFactory;
use App\Handler\DefaultErrorHandler;
use App\Middleware\TranslatorMiddleware;
use Cake\Database\Connection;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Middleware\ErrorMiddleware;
use Slim\Psr7\Factory\UriFactory;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Slim\Views\TwigMiddleware;
use Slim\Views\TwigRuntimeLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

return [
    // Application settings
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
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
        return new LoggerFactory($container->get('settings')['logger']);
    },

    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer($container->get(App::class), Twig::class);
    },

    // Twig templates
    Twig::class => function (ContainerInterface $container) {
        $config = (array)$container->get('settings');
        $settings = $config['twig'];

        $options = $settings['options'];
        $options['cache'] = $options['cache_enabled'] ? $options['cache_path'] : false;

        $twig = Twig::create($settings['paths'], $options);

        $loader = $twig->getLoader();
        $publicPath = (string)$config['public'];
        if ($loader instanceof FilesystemLoader) {
            $loader->addPath($publicPath, 'public');
        }

        // Add extensions
        $twig->addExtension(new TranslationExtension($container->get(Translator::class)));
        $twig->addExtension(new WebpackExtension(
            $publicPath . '/assets/manifest.json',
            'assets/',
            'assets/'
        ));

        // Add the Twig extension only if we run the application from the command line / cron job,
        // but not when phpunit tests are running.
        if ((PHP_SAPI === 'cli') && !defined('PHPUNIT_TEST_SUITE')) {
            $app = $container->get(App::class);
            $routeParser = $app->getRouteCollector()->getRouteParser();
            $uri = (new UriFactory())->createUri('http://localhost');

            $runtimeLoader = new TwigRuntimeLoader($routeParser, $uri);
            $twig->addRuntimeLoader($runtimeLoader);
            $twig->addExtension(new TwigExtension());
        }

        /** @var FlashBagInterface $flashbag */
        $flashbag = $container->get(Session::class)->getFlashBag();
        $environment = $twig->getEnvironment();
        $environment->addGlobal('flashbag', $flashbag);
        $environment->addFunction(new TwigFunction(
            'flash',
            function (string $key, $default = null) use ($flashbag) {
                return $flashbag->get($key, $default ?? [])[0] ?? null;
            }
        ));

        return $twig;
    },

    Session::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['session'];

        if (PHP_SAPI === 'cli') {
            return new Session(new MockArraySessionStorage());
        } else {
            return new Session(new NativeSessionStorage($settings));
        }
    },

    SessionInterface::class => function (ContainerInterface $container) {
        return $container->get(Session::class);
    },

    // Translation
    Translator::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['translation'];

        $translator = new Translator(
            $settings['locale'],
            new MessageFormatter(new IdentityTranslator()),
            $settings['cache_enabled'] ? $settings['cache'] : null,
            $settings['debug']
        );

        $translator->addLoader('mo', new MoFileLoader());

        // Set translator instance
        __($translator);

        return $translator;
    },

    TranslatorMiddleware::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['translation'];
        $translator = $container->get(Translator::class);
        $session = $container->get(Session::class);

        return new TranslatorMiddleware($translator, $session, (string)$settings['path']);
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return new BasePathMiddleware($app);
    },

    // Database connection
    Connection::class => function (ContainerInterface $container) {
        return new Connection($container->get('settings')['db']);
    },

    PDO::class => function (ContainerInterface $container) {
        $db = $container->get(Connection::class);
        $driver = $db->getDriver();
        $driver->connect();

        return $driver->getConnection();
    },

    ValidationExceptionMiddleware::class => function (ContainerInterface $container) {
        $factory = $container->get(ResponseFactoryInterface::class);

        return new ValidationExceptionMiddleware(
            $factory,
            new ErrorDetailsResultTransformer(),
            new JsonEncoder()
        );
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $config = $container->get('settings')['error'];
        $app = $container->get(App::class);

        $logger = $container->get(LoggerFactory::class)
            ->addFileHandler('error.log')
            ->createInstance('default_error_handler');

        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$config['display_error_details'],
            (bool)$config['log_errors'],
            (bool)$config['log_error_details'],
            $logger
        );

        $errorMiddleware->setDefaultErrorHandler($container->get(DefaultErrorHandler::class));

        return $errorMiddleware;
    },
];
