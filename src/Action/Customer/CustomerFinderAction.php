<?php

namespace App\Action\Customer;

use App\Domain\Customer\Data\CustomerFinderResult;
use App\Domain\Customer\Service\CustomerFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CustomerFinderAction
{
    private CustomerFinder $customerFinder;

    private JsonRenderer $jsonRenderer;

    public function __construct(CustomerFinder $customerFinder, JsonRenderer $jsonRenderer)
    {
        $this->customerFinder = $customerFinder;
        $this->jsonRenderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        $customers = $this->customerFinder->findCustomers();

        return $this->jsonRenderer->json($response, $this->transform($customers));
    }

    public function transform(CustomerFinderResult $collection): array
    {
        $customers = [];

        foreach ($collection->customers as $customer) {
            $customers[] = [
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

        return [
            'customers' => $customers,
        ];
    }
}
