<?php

namespace App\Domain\AnnoDomini\Data;

use Selective\ArrayReader\ArrayReader;

/**
 * Data Model.
 */
final class CardData
{
    public ?int $id = null;
    public string $card_id;
    public string $set_id;
    public string $event;
    public ?string $event_image = null;
    public int $event_date;
    public ?int $event_period = null;
    public int $event_around;
    public int $event_century;
    public int $event_millenium;
    public ?string $event_additional_info = null;
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
        $this->card_id = $reader->findString('card_id');
        $this->set_id = $reader->findInt('set_id');
        $this->event = $reader->findString('event');
        $this->event_image = $reader->findString('event_image');
        $this->event_date = $reader->findInt('event_date');
        $this->event_period = $reader->findInt('event_period');
        $this->event_around = $reader->findInt('event_around');
        $this->event_century = $reader->findInt('event_century');
        $this->event_millenium = $reader->findInt('event_millenium');
        $this->event_additional_info = $reader->findString('event_additional_info');
        $this->create_date = $reader->findInt('create_date');
    }

    
}