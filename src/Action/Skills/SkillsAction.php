<?php

namespace App\Action\Skills;

use App\Domain\Skills\Service\SkillsService;
use App\Renderer\JsonRenderer;

class SkillsAction
{
    protected SkillsService $service;

    protected JsonRenderer $renderer;

    /**
     * @param SkillsService $service
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(SkillsService $service, JsonRenderer $jsonRenderer)
    {
        $this->service = $service;
        $this->renderer = $jsonRenderer;
    }
}