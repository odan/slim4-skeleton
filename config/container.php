<?php

use App\Middleware\TranslatorMiddleware;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Odan\Twig\TwigAssetsExtension;
use Odan\Twig\TwigTranslationExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
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
$container->share(ContainerInterface::class, static function (Container $container) {
    return $container;
})->addArgument($container);

// Application settings
$container->share('settings', static function () {
    return (require __DIR__ . '/settings.php')();
});

// Slim App
$container->share(App::class, static function (Container $container) {
    AppFactory::setContainer($container);
    $app = AppFactory::create();

    // Set the base path to run the app in a subdirectory.
    // This path is used in urlFor().
    $basePath = (new BasePathDetector($_SERVER))->getBasePath();
    $app->setBasePath($basePath);

    return $app;
})->addArgument($container);

// For the HtmlResponder
$container->share(ResponseFactoryInterface::class, static function () {
    return new ResponseFactory();
});

// The Slim RouterParser
$container->share(RouteParserInterface::class, static function (Container $container) {
    return $container->get(App::class)->getRouteCollector()->getRouteParser();
})->addArgument($container);

// The logger
$container->share(LoggerInterface::class, static function (Container $container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Logger($settings['name']);

    $level = isset($settings['level']) ?: Logger::ERROR;
    $filename = sprintf('%s/%s', $settings['path'], $settings['filename']);

    $handler = new RotatingFileHandler($filename, 0, $level, true, 0775);
    $logger->pushHandler($handler);

    return $logger;
})->addArgument($container);

// Twig templates
$container->share(Twig::class, static function (Container $container) {
    $settings = $container->get('settings');
    $viewPath = $settings['twig']['path'];

    $twig = new Twig($viewPath, [
        'cache' => $settings['twig']['cache_enabled'] ? $settings['twig']['cache_path'] : false,
    ]);

    $loader = $twig->getLoader();
    if ($loader instanceof FilesystemLoader) {
        $loader->addPath($settings['public'], 'public');
    }

    $environment = $twig->getEnvironment();

    // Add CSRF token as global template variable
    //$csrfToken = $container->get(CsrfMiddleware::class)->getToken();
    //$environment->addGlobal('csrf_token', $csrfToken);

    // Add relative base url
    $routeParser = $container->get(RouteParserInterface::class);
    $environment->addGlobal('base_path', $routeParser->urlFor('root'));

    // Add Twig extensions
    $twig->addExtension(new TwigAssetsExtension($environment, (array)$settings['assets']));
    $twig->addExtension(new TwigTranslationExtension());

    return $twig;
})->addArgument($container);

// Translation
$container->share(Translator::class, static function (Container $container) {
    $settings = $container->get('settings')['locale'];

    $translator = new Translator(
        $settings['locale'],
        new MessageFormatter(new IdentityTranslator()),
        $settings['cache']
    );

    $translator->addLoader('mo', new MoFileLoader());

    // Set translator instance
    __($translator);

    return $translator;
})->addArgument($container);

$container->share(TranslatorMiddleware::class, static function (Container $container) {
    $settings = $container->get('settings')['locale'];
    $localPath = $settings['path'];
    $translator = $container->get(Translator::class);

    return new TranslatorMiddleware($translator, $localPath);
})->addArgument($container);

return $container;
