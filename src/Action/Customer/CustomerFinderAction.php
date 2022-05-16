<?php

namespace App\Action\Customer;

use App\Domain\Customer\Service\CustomerFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action.
 */
final class CustomerFinderAction
{
    private CustomerFinder $customerFinder;

    private JsonRenderer $jsonRenderer;

    /**
     * The constructor.
     *
     * @param CustomerFinder $customerFinder The service
     * @param JsonRenderer $jsonRenderer The renderer
     */
    public function __construct(CustomerFinder $customerFinder, JsonRenderer $jsonRenderer)
    {
        $this->customerFinder = $customerFinder;
        $this->jsonRenderer = $jsonRenderer;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        $result = $this->customerFinder->findCustomers();

        return $this->jsonRenderer->json($response, $result);
    }
}
