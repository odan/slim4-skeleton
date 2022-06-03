<?php

namespace App\Action\Customer;

use App\Domain\Customer\Service\CustomerUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CustomerUpdaterAction
{
    private CustomerUpdater $customerUpdater;

    private JsonRenderer $renderer;

    public function __construct(CustomerUpdater $customerUpdater, JsonRenderer $jsonRenderer)
    {
        $this->customerUpdater = $customerUpdater;
        $this->renderer = $jsonRenderer;
    }

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
        return $this->renderer->json($response);
    }
}
