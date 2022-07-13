<?php

namespace App\Action\Customer;

use App\Domain\Customer\Service\CustomerCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CustomerCreatorAction
{
    private JsonRenderer $renderer;

    private CustomerCreator $customerCreator;

    public function __construct(CustomerCreator $customerCreator, JsonRenderer $renderer)
    {
        $this->customerCreator = $customerCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $customerId = $this->customerCreator->createCustomer($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['customer_id' => $customerId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
