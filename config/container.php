<?php

use App\Factory\LoggerFactory;
use App\Middleware\TranslatorMiddleware;
use App\Utility\Configuration;
use Cake\Database\Connection;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Odan\Twig\TwigTranslationExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathDetector;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Views\Twig;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Loader\FilesystemLoader;

$container = new Container();

$container->delegate(new ReflectionContainer());

// The container
$container->share(ContainerInterface::class, static function (ContainerInterface $container) {
    return $container;
})->addArgument($container);

// Application settings
$container->share(Configuration::class, static function () {
    return new Configuration(require __DIR__ . '/settings.php');
});

// Slim App
$container->share(App::class, static function (ContainerInterface $container) {
    AppFactory::setContainer($container);
    $app = AppFactory::create();

    // Set the base path to run the app in a subdirectory.
    // This path is used in urlFor().
    $basePath = (new BasePathDetector($_SERVER))->getBasePath();
    $app->setBasePath($basePath);

    $config = $container->get(Configuration::class);
    $routeCacheFile = $config->get('router')['cache_file'];
    if ($routeCacheFile) {
        $app->getRouteCollector()->setCacheFile($routeCacheFile);
    }

    return $app;
})->addArgument($container);

// For the HtmlResponder
$container->share(ResponseFactoryInterface::class, static function () {
    return new ResponseFactory();
});

// The Slim RouterParser
$container->share(RouteParserInterface::class, static function (ContainerInterface $container) {
    return $container->get(App::class)->getRouteCollector()->getRouteParser();
})->addArgument($container);

// The logger factory
$container->share(LoggerFactory::class, static function (ContainerInterface $container) {
    return new LoggerFactory($container->get(Configuration::class)->get('logger'));
})->addArgument($container);

// Twig templates
$container->share(Twig::class, static function (ContainerInterface $container) {
    $config = $container->get(Configuration::class);
    $twigSettings = $config->get('twig');

    $twig = new Twig($twigSettings['path'], [
        'cache' => $twigSettings['cache_enabled'] ? $twigSettings['cache_path'] : false,
    ]);

    $loader = $twig->getLoader();
    if ($loader instanceof FilesystemLoader) {
        $loader->addPath($config->get('public'), 'public');
    }

    $environment = $twig->getEnvironment();

    // Add relative base url
    $basePath = $container->get(App::class)->getBasePath();
    $environment->addGlobal('base_path', $basePath . '/');

    // Add Twig extensions
    $twig->addExtension(new TwigTranslationExtension());

    $twig->addExtension(new WebpackExtension(
        $config->get('public') . '/assets/manifest.json',
        $basePath . '/assets/',
        $basePath . '/assets/'
    ));

    return $twig;
})->addArgument($container);

// Translation
$container->share(Translator::class, static function (ContainerInterface $container) {
    $settings = $container->get(Configuration::class)->get('locale');

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
})->addArgument($container);

$container->share(TranslatorMiddleware::class, static function (ContainerInterface $container) {
    $settings = $container->get(Configuration::class)->get('locale');
    $localPath = $settings['path'];
    $translator = $container->get(Translator::class);

    return new TranslatorMiddleware($translator, $localPath);
})->addArgument($container);

$container->share(Connection::class, static function (Container $container) {
    return new Connection($container->get(Configuration::class)->get('db'));
})->addArgument($container);

$container->share(PDO::class, static function (Container $container) {
    $db = $container->get(Connection::class);
    $db->getDriver()->connect();

    return $db->getDriver()->getConnection();
})->addArgument($container);

return $container;
