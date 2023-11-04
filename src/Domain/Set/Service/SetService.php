<?php

namespace App\Domain\Set\Service;

use Apollo29\AnnoDomini\Data\SetData;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use Psr\Log\LoggerInterface;

class SetService
{
    private AnnoDominiRepository $repository;

    private SetValidator $validator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param AnnoDominiRepository $repository The repository
     * @param SetValidator $validator The validator
     * @param LoggerInterface $logger The logger interface
     */
    public function __construct(
        AnnoDominiRepository $repository,
        SetValidator         $validator,
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
        $item = new SetData($data);
        $itemId = $this->repository->insertSet($item);
        $this->logger->info(sprintf('Set created successfully: %s', $itemId));
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
        $item = new SetData($data);
        $item->id = $itemId;
        $this->repository->updateSet($item);
        $this->logger->info(sprintf('Set updated successfully: %s', $itemId));
    }

    /**
     * Read an item.
     *
     * @param int $itemId The item id
     *
     * @return SetData The item data
     */
    public function getById(int $itemId): SetData
    {
        return $this->repository->getSetById($itemId);
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
        $this->repository->deleteSetById($id);
    }
}