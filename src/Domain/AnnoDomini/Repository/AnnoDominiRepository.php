<?php

namespace App\Domain\AnnoDomini\Repository;

use App\Domain\AnnoDomini\Data\CardData;
use App\Factory\QueryFactory;
use DomainException;

/**
 * Repository.
 */
final class AnnoDominiRepository
{
    private QueryFactory $queryFactory;

    // Card
    public static string $CARD_TABLE_NAME = "playing_card";
    public static array $CARD_MODEL = [
        'id',
        'card_id',
        'set_id',
        'event',
        'event_image',
        'event_date',
        'event_period',
        'event_around',
        'event_century',
        'event_millenium',
        'event_additional_info',
        'create_date',
    ];
    // Opponent
    public static string $OPPONENT_TABLE_NAME = "opponent";
    public static array $OPPONENT_MODEL = [
        'id',
        'name',
        'level',
        'confident',
        'fortune',
        'education',
        'avatar',
        'create_date',
    ];
    // Set
    public static string $SET_TABLE_NAME = "game_set";
    public static array $SET_MODEL = [
        'uid',
        'product_id',
        'name',
        'icon',
        'color',
        'foreground_color',
        'create_date',
        'active',
        'additional_info',
        'title_image',
        'year',
    ];
    // Skills
    public static string $SKILLS_TABLE_NAME = "opponent_skills";
    public static array $SKILLS_MODEL = [
        'id',
        'opponent_id',
        'set_id',
        'skill',
        'create_date',
    ];

    /**
     * The constructor.
     *
     * @param QueryFactory $queryFactory The query factory
     */
    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    /**
     * Insert Card.
     *
     * @param CardData $item The item data
     *
     * @return int The new ID
     */
    public function insertCard(CardData $item): int
    {
        return (int)$this->queryFactory->newInsert($this::$CARD_TABLE_NAME, $this->toRow($item))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Insert Opponent.
     *
     * @param OpponentData $item The item data
     *
     * @return int The new ID
     */
    public function insertOpponent(OpponentData $item): int
    {
        return (int)$this->queryFactory->newInsert($this::$OPPONENT_TABLE_NAME, $this->toRow($item))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Insert Set.
     *
     * @param SetData $item The item data
     *
     * @return int The new ID
     */
    public function insertSet(SetData $item): int
    {
        return (int)$this->queryFactory->newInsert($this::$SET_TABLE_NAME, $this->toRow($item))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Insert Skills.
     *
     * @param SkillsData $item The item data
     *
     * @return int The new ID
     */
    public function insertSkills(SkillsData $item): int
    {
        return (int)$this->queryFactory->newInsert($this::$SKILLS_TABLE_NAME, $this->toRow($item))
            ->execute()
            ->lastInsertId();
    }

    /**
     * Get Card by id.
     *
     * @param int $id The item id
     *
     * @throws DomainException
     *
     * @return CardData The item
     */
    public function getCardById(int $id): CardData
    {
        $query = $this->queryFactory->newSelect($this::$CARD_TABLE_NAME);
        $query->select($this::$CARD_MODEL);

        $query->andWhere(['id' => $id]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Card not found: %s', $id));
        }

        return new CardData($row);
    }

    /**
     * Get Opponent by id.
     *
     * @param int $id The item id
     *
     * @throws DomainException
     *
     * @return OpponentData The item
     */
    public function getOpponentById(int $id): OpponentData
    {
        $query = $this->queryFactory->newSelect($this::$OPPONENT_TABLE_NAME);
        $query->select($this::$OPPONENT_MODEL);

        $query->andWhere(['id' => $id]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Opponent not found: %s', $id));
        }

        return new OpponentData($row);
    }

    /**
     * Get Set by id.
     *
     * @param int $id The item id
     *
     * @throws DomainException
     *
     * @return SetData The item
     */
    public function getSetById(int $id): SetData
    {
        $query = $this->queryFactory->newSelect($this::$SET_TABLE_NAME);
        $query->select($this::$SET_MODEL);

        $query->andWhere(['id' => $id]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Set not found: %s', $id));
        }

        return new SetData($row);
    }

    /**
     * Get Skills by id.
     *
     * @param int $id The item id
     *
     * @throws DomainException
     *
     * @return SkillsData The item
     */
    public function getSkillsById(int $id): SkillsData
    {
        $query = $this->queryFactory->newSelect($this::$SKILLS_TABLE_NAME);
        $query->select($this::$SKILLS_MODEL);

        $query->andWhere(['id' => $id]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Skills not found: %s', $id));
        }

        return new SkillsData($row);
    }

    /**
     * Update Card row.
     *
     * @param CardData $item The item
     *
     * @return void
     */
    public function updateCard(CardData $item): void
    {
        $row = $this->toRow($item);

        $this->queryFactory->newUpdate($this::$CARD_TABLE_NAME, $row)
            ->andWhere(['id' => $item->id])
            ->execute();
    }

    /**
     * Update Opponent row.
     *
     * @param OpponentData $item The item
     *
     * @return void
     */
    public function updateOpponent(OpponentData $item): void
    {
        $row = $this->toRow($item);

        $this->queryFactory->newUpdate($this::$OPPONENT_TABLE_NAME, $row)
            ->andWhere(['id' => $item->id])
            ->execute();
    }    

    /**
     * Update Set row.
     *
     * @param SetData $item The item
     *
     * @return void
     */
    public function updateSet(SetData $item): void
    {
        $row = $this->toRow($item);

        $this->queryFactory->newUpdate($this::$SET_TABLE_NAME, $row)
            ->andWhere(['id' => $item->id])
            ->execute();
    }  

     /**
     * Update Skills row.
     *
     * @param SkillsData $item The item
     *
     * @return void
     */
    public function updateSkills(SkillsData $item): void
    {
        $row = $this->toRow($item);

        $this->queryFactory->newUpdate($this::$SKILLS_TABLE_NAME, $row)
            ->andWhere(['id' => $item->id])
            ->execute();
    }   

    /**
     * Check item id.
     *
     * @param int $id The item id
     * @param string $table The Table/Type of Data
     *
     * @return bool True if exists
     */
    public function existsId(int $id, string $table): bool
    {

        $query = $this->queryFactory->newSelect($table);
        $query->select('id')->andWhere(['id' => $id]);

        return (bool)$query->execute()->fetch('assoc');
    }

    /**
     * Delete Card.
     *
     * @param int $id The item id
     *
     * @return void
     */
    public function deleteCardById(int $id): void
    {
        $this->queryFactory->newDelete($this::$CARD_TABLE_NAME)
            ->andWhere(['id' => $id])
            ->execute();
    }

    /**
     * Delete Opponent.
     *
     * @param int $id The item id
     *
     * @return void
     */
    public function deleteOpponentById(int $id): void
    {
        $this->queryFactory->newDelete($this::$OPPONENT_TABLE_NAME)
            ->andWhere(['id' => $id])
            ->execute();
    } 

    /**
     * Delete Set.
     *
     * @param int $id The item id
     *
     * @return void
     */
    public function deleteSetById(int $id): void
    {
        $this->queryFactory->newDelete($this::$SET_TABLE_NAME)
            ->andWhere(['id' => $id])
            ->execute();
    }    

    /**
     * Delete Skills.
     *
     * @param int $id The item id
     *
     * @return void
     */
    public function deleteSkillsById(int $id): void
    {
        $this->queryFactory->newDelete($this::$SKILLS_TABLE_NAME)
            ->andWhere(['id' => $id])
            ->execute();
    }      

    /**
     * Convert to array.
     *
     * @param Object $item The item data
     *
     * @return array The array
     */
    private function toRow(Object $item): array
    {
        return (array) $item;
    }
}