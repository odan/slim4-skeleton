<?php

namespace App\Action\Set;

use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use App\Renderer\JsonRenderer;

abstract class SetAction
{
    protected AnnoDominiRepository $repository;

    protected JsonRenderer $renderer;

    /**
     * @param AnnoDominiRepository $repository
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(AnnoDominiRepository $repository, JsonRenderer $jsonRenderer)
    {
        $this->repository = $repository;
    }
}
