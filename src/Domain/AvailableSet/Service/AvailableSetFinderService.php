<?php

namespace App\Domain\AvailableSet\Service;

use Apollo29\AnnoDomini\Data\AvailableSetData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class AvailableSetFinderService
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
     * @return AvailableSetData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findAvailableSets();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return AvailableSetData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findAvailableSetsByDate($date);
    }
}