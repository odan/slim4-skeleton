<?php

namespace App\Domain\VirtualCard\Service;

use Apollo29\AnnoDomini\Data\SetData;
use Apollo29\AnnoDomini\Data\VirtualCardDetailData;
use Apollo29\AnnoDomini\Data\VirtualSetData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class VirtualCardFinderService
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
     * @return VirtualCardDetailData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findVirtualCardDetails();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return VirtualCardDetailData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findVirtualCardDetailByDate($date);
    }
}