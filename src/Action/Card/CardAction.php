<?php

namespace App\Action\Card;

use App\Domain\Card\Service\CardReviewService;
use App\Renderer\JsonRenderer;

class CardAction
{
    protected CardReviewService $service;

    protected JsonRenderer $renderer;

    /**
     * @param CardReviewService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(CardReviewService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }
}