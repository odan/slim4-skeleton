<?php

namespace App\Domain\Card\Service;

use Apollo29\AnnoDomini\Data\CardMistakeData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class CardMistakeService
{
    private AnnoDominiFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param AnnoDominiFinderRepository $repository The repository
     */
    public function __construct(AnnoDominiFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find items.
     *
     * @return CardMistakeData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findCardMistakes();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return CardMistakeData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findCardMistakesByDate($date);
    }
}