<?php

namespace App\Domain\Card\Service;

use Apollo29\AnnoDomini\Data\CardData;
use Apollo29\AnnoDomini\Repository\AnnoDominiRepository;
use Apollo29\AnnoDomini\Service\SetValidator;
use Psr\Log\LoggerInterface;

class CardReviewService
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
     * @return array The new item ID and CardID
     */
    public function create(array $data): array
    {
        $this->validator->validate($data);
        $item = new CardData($data);
        $itemId = $this->repository->insertCardReview($item);
        $this->logger->info(sprintf('Card created successfully: %s', $itemId));
        return ["id" => $itemId, "card_id" => $item->card_id];
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
        $this->repository->updateCardReview($item);
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
        return $this->repository->getCardReviewById($itemId);
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
        $this->repository->deleteCardReviewById($id);
    }
}