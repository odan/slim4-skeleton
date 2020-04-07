<?php

namespace App\Action\User;

use App\Domain\User\Service\UserViewer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

/**
 * Action.
 */
final class UserViewAction
{
    /**
     * @var UserViewer
     */
    private $userReader;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * The constructor.
     *
     * @param UserViewer $userViewer The service
     * @param Twig $twig The twig engine
     */
    public function __construct(UserViewer $userViewer, Twig $twig)
    {
        $this->userReader = $userViewer;
        $this->twig = $twig;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The routing argumtents
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId = (int)$args['id'];

        // Invoke the domain (service class)
        $user = $this->userReader->getUserViewData($userId);

        // Prepare the view data
        $viewData = [
            'user' => $user
        ];

        // Render the twig template with the given view data
        return $this->twig->render($response, 'user/user-view.twig', $viewData);
    }
}
