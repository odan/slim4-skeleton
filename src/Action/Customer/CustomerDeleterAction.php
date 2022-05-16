<?php

namespace App\Action\Customer;

use App\Domain\Customer\Service\CustomerDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CustomerDeleterAction
{
    private CustomerDeleter $companyDeleter;

    private JsonRenderer $renderer;

    /**
     * The constructor.
     *
     * @param CustomerDeleter $customerDeleter The service
     * @param JsonRenderer $renderer The responder
     */
    public function __construct(CustomerDeleter $customerDeleter, JsonRenderer $renderer)
    {
        $this->companyDeleter = $customerDeleter;
        $this->renderer = $renderer;
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
        $customerId = (int)$args['customer_id'];

        // Invoke the domain (service class)
        $this->companyDeleter->deleteCustomer($customerId);

        // Render the json response
        return $this->renderer->json($response);
    }
}
