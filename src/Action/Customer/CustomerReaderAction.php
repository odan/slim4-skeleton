<?php

namespace App\Action\Customer;

use App\Domain\Customer\Data\CustomerReaderResult;
use App\Domain\Customer\Service\CustomerReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CustomerReaderAction
{
    private CustomerReader $customerReader;

    private JsonRenderer $jsonRenderer;

    public function __construct(CustomerReader $companyReader, JsonRenderer $jsonRenderer)
    {
        $this->customerReader = $companyReader;
        $this->jsonRenderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $customerId = (int)$args['customer_id'];

        // Invoke the domain (service class)
        $customer = $this->customerReader->getCustomer($customerId);

        return $this->jsonRenderer->json($response, $this->transform($customer));
    }

    private function transform(CustomerReaderResult $customer): array
    {
        return [
            'id' => $customer->id,
            'number' => $customer->number,
            'name' => $customer->name,
            'street' => $customer->street,
            'postal_code' => $customer->postalCode,
            'city' => $customer->city,
            'country' => $customer->country,
            'email' => $customer->email,
        ];
    }
}
