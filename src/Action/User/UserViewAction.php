<?php

namespace App\Action\User;

use App\Domain\User\Service\UserViewer;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var Responder
     */
    private $responder;

    /**
     * The constructor.
     *
     * @param UserViewer $userViewer The service
     * @param Responder $responder The responder
     */
    public function __construct(UserViewer $userViewer, Responder $responder)
    {
        $this->userReader = $userViewer;
        $this->responder = $responder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The routing arguments
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
            'user' => $user,
        ];

        // Render the twig template with the given view data
        return $this->responder->render($response, 'user/user-view.twig', $viewData);
    }
}
