<?php

namespace App\Domain\VirtualSet\Service;

use Apollo29\AnnoDomini\Data\SetData;
use Apollo29\AnnoDomini\Data\VirtualSetData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class VirtualSetFinderService
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
     * @return SetData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findVirtualSets();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return VirtualSetData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findVirtualSetByDate($date);
    }
}