<?php

namespace App\Action\Info;

use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class InfoFindSetAction
{
    private AnnoDominiFinderRepository $repository;

    private JsonRenderer $renderer;

    /**
     * @param AnnoDominiFinderRepository $repository
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(AnnoDominiFinderRepository $repository, JsonRenderer $jsonRenderer)
    {
        $this->repository = $repository;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->repository->setInfoList();
        return $this->transform($response, $data);
    }

    /**
     * Transform to json response.
     * This could also be done within a specific Responder class.
     *
     * @param ResponseInterface $response The response
     * @param array $data The data
     *
     * @return ResponseInterface The response
     */
    private function transform(ResponseInterface $response, array $data): ResponseInterface
    {
        $list = [];

        foreach ($data as $item) {
            $list[] = (array)$item;
        }

        return $this->renderer->json(
            $response,
            [
                'data' => $list,
            ]
        );
    }
}
