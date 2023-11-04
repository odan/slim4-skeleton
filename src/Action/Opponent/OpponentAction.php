<?php

namespace App\Action\Opponent;

use App\Domain\Opponent\Service\OpponentService;
use App\Renderer\JsonRenderer;

abstract class OpponentAction
{
    protected OpponentService $service;

    protected JsonRenderer $renderer;

    /**
     * @param OpponentService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(OpponentService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }
}
