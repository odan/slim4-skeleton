<?php

namespace App\Domain\Opponent\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class OpponentData
{
    public ?int $id = null;
    public string $name;
    public int $level;
    public int $confident;
    public int $fortune;
    public int $education;
    public ?string $avatar = null;
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
        $this->name = $reader->findString('name');
        $this->level = $reader->findInt('level', 1);
        $this->confident = $reader->findInt('confident', 3);
        $this->fortune = $reader->findInt('fortune', 3);
        $this->education = $reader->findInt('education', 3);
        $this->avatar = $reader->findString('avatar');
        $this->create_date = $reader->findInt('create_date');
    }
}