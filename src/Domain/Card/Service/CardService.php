<?php

namespace App\Domain\Card\Service;

use Apollo29\AnnoDomini\Data\CardData;
use Apollo29\AnnoDomini\Data\SkillsData;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use Apollo29\AnnoDomini\Service\CardValidator;
use Apollo29\AnnoDomini\Service\SetValidator;
use Psr\Log\LoggerInterface;

class CardService
{
    private AnnoDominiRepository $repository;

    private CardValidator $validator;

    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param AnnoDominiRepository $repository The repository
     * @param CardValidator $validator The validator
     * @param LoggerInterface $logger The logger interface
     */
    public function __construct(
        AnnoDominiRepository $repository,
        CardValidator $validator,
        LoggerInterface $logger
    ) {
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
        $item = new CardData($data);
        $itemId = $this->repository->insertCard($item);
        $this->logger->info(sprintf('Card created successfully: %s', $itemId));
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
        $item = new CardData($data);
        $item->id = $itemId;
        $this->repository->updateCard($item);
        $this->logger->info(sprintf('Card updated successfully: %s', $itemId));
    }

    /**
     * Read an item.
     *
     * @param int $itemId The item id
     *
     * @return CardData The item data
     */
    public function getById(int $itemId): CardData
    {
        return $this->repository->getCardById($itemId);
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
        $this->repository->deleteCardById($id);
    }
}