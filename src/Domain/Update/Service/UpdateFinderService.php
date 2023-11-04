<?php

namespace App\Domain\Update\Service;

use Apollo29\AnnoDomini\Data\SetData;
use Apollo29\AnnoDomini\Data\SkillsData;
use Apollo29\AnnoDomini\Data\UpdateData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class UpdateFinderService
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
        return $this->repository->findUpdate();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return UpdateData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findUpdateByDate($date);
    }
}