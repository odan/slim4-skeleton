<?php

namespace App\Action\Auth;

use App\Domain\Auth\Service\AuthService;
use App\Renderer\JsonRenderer;
use App\Support\JwtAuth;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Auth Action to receive a JWT Token
 */
final class AuthAction
{

    protected AuthService $service;

    protected JwtAuth $jwtAuth;

    protected JsonRenderer $renderer;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param AuthService $service The Auth Service
     * @param JwtAuth $jwtAuth JWT Auth Service
     * @param JsonRenderer $renderer The JSON Renderer
     * @param LoggerInterface $logger the Logger interface
     */
    public function __construct(AuthService $service, JwtAuth $jwtAuth, JsonRenderer $renderer, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->jwtAuth = $jwtAuth;
        $this->renderer = $renderer;
        $this->logger = $logger;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response interface
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = (array)$request->getParsedBody();
        $isValid = $this->service->validate($params);

        if (!$isValid) {
            $this->logger->warning("Unauthorized auth attempt" . json_encode($params));
            return $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED, "Unauthorized");
        }

        // Create a fresh token
        $token = $this->jwtAuth->createJwt($params['username']);
        $lifetime = $this->jwtAuth->getLifetime();

        // Transform the result into a OAuh 2.0 Access Token Response
        // https://www.oauth.com/oauth2-servers/access-tokens/access-token-response/
        $result = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $lifetime
        ];

        return $this->renderer
            ->json($response, $result)
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
