<?php

namespace App\Domain\Opponent\Service;

use Apollo29\AnnoDomini\Data\OpponentData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class OpponentFinderService
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
     * @return OpponentData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findOpponents();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return OpponentData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findOpponentsByDate($date);
    }
}