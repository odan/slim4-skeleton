<?php

namespace App\Domain\Opponent\Service;

use Apollo29\AnnoDomini\Data\OpponentData;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use Apollo29\AnnoDomini\Service\OpponentValidator;
use Psr\Log\LoggerInterface;

class OpponentService
{
    private AnnoDominiRepository $repository;

    private OpponentValidator $validator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param AnnoDominiRepository $repository The repository
     * @param OpponentValidator $validator The validator
     * @param LoggerInterface $logger The logger interface
     */
    public function __construct(
        AnnoDominiRepository $repository,
        OpponentValidator    $validator,
        LoggerInterface      $logger
    )
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * Create a new item.
     *
     * @param array $data The form data
     *
     * @return int The new item ID
     */
    public function create(array $data): int
    {
        $this->validator->validate($data);
        $item = new OpponentData($data);
        $itemId = $this->repository->insertOpponent($item);
        $this->logger->info(sprintf('Opponent created successfully: %s', $itemId));
        return $itemId;
    }

    /**
     * Update item.
     *
     * @param int $itemId The item id
     * @param array $data The request data
     *
     * @return void
     */
    public function update(int $itemId, array $data): void
    {
        $this->validator->validateUpdate($itemId, $data);
        $item = new OpponentData($data);
        $item->id = $itemId;
        $this->repository->updateOpponent($item);
        $this->logger->info(sprintf('Opponent updated successfully: %s', $itemId));
    }

    /**
     * Read an item.
     *
     * @param int $itemId The item id
     *
     * @return OpponentData The item data
     */
    public function getById(int $itemId): OpponentData
    {
        return $this->repository->getOpponentById($itemId);
    }

    /**
     * Delete item.
     *
     * @param int $id The item id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->deleteOpponentById($id);
    }
}