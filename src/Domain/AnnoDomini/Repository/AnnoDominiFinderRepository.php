<?php

namespace App\Domain\AnnoDomini\Repository;

use App\Domain\AnnoDomini\Data\CardData;
use App\Factory\QueryFactory;
use App\Support\Hydrator;

/**
 * Repository.
 */
final class AnnoDominiFinderRepository
{
    private QueryFactory $queryFactory;

    private Hydrator $hydrator;

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     * @param Hydrator $hydrator The hydrator
     */
    public function __construct(QueryFactory $queryFactory, Hydrator $hydrator)
    {
        $this->queryFactory = $queryFactory;
        $this->hydrator = $hydrator;
    }

    /**
     * Card Query Factory.
     *
     * @return ?queryFactory Card Query Factory
     */
    private function queryCards(): ?queryFactory
    {
        return $this->queryFactory->newSelect(AnnoDominiRepository::$CARD_TABLE_NAME);
    }

    /**
     * Find Card items.
     *
     * @return CardData[] A list of items
     */
    public function findCards(): array
    {
        $query = $this->queryCards();

        $query->select(AnnoDominiRepository::$SET_MODEL);

        // Add more "use case specific" conditions to the query
        // ...

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        // Convert to list of objects
        return $this->hydrator->hydrate($rows, CardData::class);
    }

    /**
     * Find items.
     *
     * @param int $date Date to select items
     * @return CardData[] A list of items
     */
    public function findCardsByDate(int $date): array
    {
        $query = $this->queryCards()
            ->andWhere(['create_date >=' => $date])
            ->select(AnnoDominiRepository::$SET_MODEL);

        $rows = $query->execute()->fetchAll('assoc') ?: [];

        // Convert to list of objects
        return $this->hydrator->hydrate($rows, CardData::class);
    }

    /**
     * Opponent Query Factory.
     *
     * @return ?queryFactory Card Query Factory
     */
    private function queryOpponents(): ?queryFactory
    {
        return $this->queryFactory->newSelect(AnnoDominiRepository::$OPPONENT_TABLE_NAME);
    }

    // todo
}