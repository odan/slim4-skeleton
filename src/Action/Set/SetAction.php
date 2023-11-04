<?php

namespace App\Action\Set;

use App\Domain\Set\Service\SetService;
use App\Renderer\JsonRenderer;

abstract class SetAction
{
    protected SetService $service;

    protected JsonRenderer $renderer;

    /**
     * @param SetService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(SetService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }
}
