<?php

namespace App\Action\Customer;

use App\Domain\Customer\Service\CustomerReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CustomerReaderAction
{
    private CustomerReader $customerReader;

    private JsonRenderer $jsonRenderer;

    /**
     * The constructor.
     *
     * @param CustomerReader $companyReader The service
     * @param JsonRenderer $jsonRenderer The responder
     */
    public function __construct(CustomerReader $companyReader, JsonRenderer $jsonRenderer)
    {
        $this->customerReader = $companyReader;
        $this->jsonRenderer = $jsonRenderer;
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
        $result = $this->customerReader->getCustomer($customerId);

        return $this->jsonRenderer->json($response, $result);
    }
}
