<?php

namespace App\Action\Card;

use App\Domain\Card\Service\CardService;
use App\Renderer\JsonRenderer;

class CardAction
{
    protected CardService $service;

    protected JsonRenderer $renderer;

    /**
     * @param CardService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(CardService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }
}