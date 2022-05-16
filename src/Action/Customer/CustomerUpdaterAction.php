<?php

namespace App\Action\Customer;

use App\Domain\Customer\Service\CustomerUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CustomerUpdaterAction
{
    private CustomerUpdater $customerUpdater;

    private JsonRenderer $jsonRenderer;

    /**
     * The constructor.
     *
     * @param CustomerUpdater $customerUpdater The service
     * @param JsonRenderer $jsonRenderer The renderer
     */
    public function __construct(CustomerUpdater $customerUpdater, JsonRenderer $jsonRenderer)
    {
        $this->customerUpdater = $customerUpdater;
        $this->jsonRenderer = $jsonRenderer;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array $args The route arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $customerId = (int)$args['customer_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->customerUpdater->updateCustomer($customerId, $data);

        // Build the HTTP response
        return $this->jsonRenderer->json($response);
    }
}
