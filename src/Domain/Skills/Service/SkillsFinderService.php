<?php

namespace App\Domain\Skills\Service;

use Apollo29\AnnoDomini\Data\SetData;
use Apollo29\AnnoDomini\Data\SkillsData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;

class SkillsFinderService
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
     * @return SkillsData[] A list of items
     */
    public function find(): array
    {
        return $this->repository->findSkills();
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @param bool $forceUpdate Force Update
     * @return SkillsData[] A list of items
     */
    public function findByDate(int $date, bool $forceUpdate = false): array
    {
        if ($forceUpdate) {
            $date = 0;
        }

        return $this->repository->findSkillsByDate($date);
    }
}