<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Translation\Translator;

/**
 * Middleware.
 */
final class TranslatorMiddleware implements MiddlewareInterface
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var string Locale path
     */
    public $localePath;

    /**
     * Constructor.
     *
     * @param Translator $translator The translator
     * @param string $localePath The directory with the locals
     */
    public function __construct(Translator $translator, string $localePath)
    {
        $this->translator = $translator;
        $this->localePath = $localePath;
    }

    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $locale = $request->getAttribute('locale');

        if (!$locale) {
            return $handler->handle($request);
        }

        $domain = 'messages';

        // Set language
        $moFile = sprintf('%s/%s_%s.mo', $this->localePath, $locale, $domain);
        $this->translator->addResource('mo', $moFile, $locale, $domain);
        $this->translator->setLocale($locale);

        return $handler->handle($request);
    }
}
