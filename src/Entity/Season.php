<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Season
{
    private int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
    }


    /** sélectionne les saisons
     * @param int $id
     * @return self|null
     */
    public static function findById(int $id): ?self
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT * 
            FROM season 
            WHERE id = ?
            SQL
        );
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }
}
