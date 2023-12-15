<?php

namespace App\Domain\Remove\Service;

use Apollo29\AnnoDomini\Data\UpdateData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class RemovalFinderService
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
     * @return UpdateData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findRemove();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return array A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }
        return $this->repository->findRemoveByDate($date);
    }
}
