<?php

namespace App\Domain\Skills\Service;

use Apollo29\AnnoDomini\Data\SkillsData;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use Apollo29\AnnoDomini\Service\SetValidator;
use Psr\Log\LoggerInterface;

class SkillsService
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
        $item = new SkillsData($data);
        $itemId = $this->repository->insertSkills($item);
        $this->logger->info(sprintf('Skills created successfully: %s', $itemId));
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
        $item = new SkillsData($data);
        $item->id = $itemId;
        $this->repository->updateSkills($item);
        $this->logger->info(sprintf('Skills updated successfully: %s', $itemId));
    }

    /**
     * Read an item.
     *
     * @param int $itemId The item id
     *
     * @return SkillsData The item data
     */
    public function getById(int $itemId): SkillsData
    {
        return $this->repository->getSkillsById($itemId);
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
        $this->repository->deleteSkillsById($id);
    }
}