<?php

namespace App\Domain\AnnoDomini\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class SetData
{
    public ?int $uid = null;
    public ?string $product_id = null;
    public string $name;
    public string $icon;
    public string $color;
    public ?string $foreground_color = null;
    public int $create_date;
    public bool $active;
    public ?string $additional_info = null;
    public ?string $title_image = null;
    public int $year;

    /**
     * The constructor.
     *
     * @param array $data The data
     */
    public function __construct(array $data = [])
    {
        $reader = new ArrayReader($data);

        $this->id = $reader->findInt('uid');
        $this->product_id = $reader->findString('product_id');
        $this->name = $reader->findString('name');
        $this->icon = $reader->findString('icon');
        $this->color = $reader->findString('color');
        $this->foreground_color = $reader->findString('foreground_color');
        $this->create_date = $reader->findInt('create_date');
        $this->active = $reader->findBool('active');
        $this->additional_info = $reader->findString('additional_info');
        $this->title_image = $reader->findString('title_image');
        $this->year = $reader->findInt('year');
    }
}