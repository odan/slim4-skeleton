<?php

namespace App\Middleware;

use App\Domain\User\Data\UserAuthData;
use Odan\Session\SessionInterface;
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
     * @var SessionInterface
     */
    private $session;

    /**
     * @var string Locale path
     */
    private $localePath;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * The constructor.
     *
     * @param Translator $translator The translator
     * @param SessionInterface $session The session handler
     * @param string $localePath The directory with the locals
     * @param string $defaultLocale The defalt language
     */
    public function __construct(
        Translator $translator,
        SessionInterface $session,
        string $localePath,
        string $defaultLocale = 'en_US'
    ) {
        $this->translator = $translator;
        $this->session = $session;
        $this->localePath = $localePath;
        $this->defaultLocale = $defaultLocale;
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
        /** @var UserAuthData|null $user */
        $user = $this->session->get('user');

        // User locale or default locale
        $locale = $user ? $user->locale : $this->defaultLocale;

        // Set language
        $domain = 'messages';
        $moFile = sprintf('%s/%s_%s.mo', $this->localePath, $locale, $domain);
        $this->translator->addResource('mo', $moFile, $locale, $domain);
        $this->translator->setLocale($locale);

        return $handler->handle($request);
    }
}
