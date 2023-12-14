<?php

namespace App\Domain\Game\Service;

use Apollo29\AnnoDomini\Data\GameData;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use Apollo29\AnnoDomini\Service\GameValidator;
use Psr\Log\LoggerInterface;

class GameService
{
    private AnnoDominiRepository $repository;
    private GameValidator $validator;
    private LoggerInterface $logger;

    /**
     * @param AnnoDominiRepository $repository
     * @param GameValidator $validator
     * @param LoggerInterface $logger
     */
    public function __construct(AnnoDominiRepository $repository, GameValidator $validator, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * Create a new item.
     *
     * @param string $player_id The player id
     *
     * @return int The new item ID
     */
    public function create(string $player_id): int
    {
        $expiry = (int) date("Ymd", strtotime("+1 day"));
        $data = ['game_id' => $this->generateId(), 'player_id' => $player_id, 'public' => false, 'expiry' => $expiry];

        $this->validator->validate($data);
        $item = new GameData($data);
        $itemId = $this->repository->insertGame($item);
        $this->logger->info(sprintf('Game created successfully: %s', $itemId));
        return $itemId;
    }

    /**
     * Delete item.
     *
     * @param int $game_id The item id
     * @param string $player_id
     * @return bool
     */
    public function delete(int $game_id, string $player_id): bool
    {
        $exist = $this->repository->existsId($game_id, AnnoDominiRepository::$GAME_TABLE_NAME, 'game_id');
        if ($exist) {
            $game = $this->repository->getGameById($game_id);
            if ($game->player_id == $player_id) {
                $this->repository->deleteGameById($game_id);
                return true;
            } else {
                $this->logger->info(sprintf('Game cannot be deleted successfully.' .
                    ' Game doesn\'t belong to Player: %s / %s', $game_id, $player_id));
            }
        } else {
            $this->logger->info(sprintf('Game cannot be deleted successfully.' .
                ' Game doesn\'t exist: %s', $game_id));
        }
        return false;
    }

    private function generateId(): int
    {
        $ids = $this->repository->getGameIds();
        return $this->randomNumber(1001, 9999, $ids);
    }

    /**
     * @param int $from From number
     * @param int $to To number
     * @param array $excluded Additionally exclude numbers
     * @return int
     */
    private function randomNumber($from, $to, array $excluded = []): int
    {
        $func = function_exists('random_int') ? 'random_int' : 'mt_rand';

        do {
            $number = $func($from, $to);
        } while (in_array($number, $excluded, true));

        return $number;
    }
}
