<?php

namespace App\Action\Game;

use App\Domain\Game\Service\GameService;
use App\Renderer\JsonRenderer;

abstract class GameAction
{
    protected GameService $service;

    protected JsonRenderer $renderer;

    /**
     * @param GameService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(GameService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }
}