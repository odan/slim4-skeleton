<?php

namespace App\Domain\Game\Service;

use Apollo29\AnnoDomini\Data\GameData;
use Apollo29\AnnoDomini\Repository\AnnoDominiFinderRepository;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;

class GameFinderService
{
    private AnnoDominiFinderRepository $finder;
    private AnnoDominiRepository $repository;

    /**
     * The constructor.
     *
     * @param AnnoDominiFinderRepository $finder The repository
     */
    public function __construct(AnnoDominiFinderRepository $finder, AnnoDominiRepository $repository)
    {
        $this->finder = $finder;
        $this->repository = $repository;
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @return GameData[] A list of items
     */
    public function findExpired(int $date): array
    {
        return $this->finder->findGameByDate($date);
    }

    public function findById(int $gameId): ?GameData
    {
        $exist = $this->repository->existsId($gameId, AnnoDominiRepository::$GAME_TABLE_NAME, 'game_id');
        if ($exist) {
            return $this->repository->getGameById($gameId);
        }
        return null;
    }
}