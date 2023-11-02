<?php

namespace App\Domain\AnnoDomini\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class SkillsData
{
    public ?int $id = null;
    public int $opponent_id;
    public int $set_id;
    public int $skill;
    public int $create_date;

    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->id = $reader->findInt('id');
        $this->opponent_id = $reader->findInt('opponent_id');
        $this->set_id = $reader->findInt('set_id');
        $this->skill = $reader->findInt('skill');
        $this->create_date = $reader->findInt('create_date');
    }
}