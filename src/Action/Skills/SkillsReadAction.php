<?php

namespace App\Action\Skills;

use Apollo29\AnnoDomini\Data\SkillsData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SkillsReadAction extends SkillsAction
{
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
        ResponseInterface      $response,
        array                  $args
    ): ResponseInterface
    {
        // Fetch parameters from the request
        $id = (int)$args['id'];

        // Invoke the domain (service class)
        $item = $this->service->getById($id);

        // Transform result
        return $this->transform($response, $item);
    }

    /**
     * Transform result to response.
     *
     * @param ResponseInterface $response The response
     * @param SkillsData $item The item
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, SkillsData $item): ResponseInterface
    {
        // Turn that object into a structured array
        $data = (array)$item;

        // Turn all of that into a JSON string and put it into the response body
        return $this->renderer->json($response, $data);
    }
}