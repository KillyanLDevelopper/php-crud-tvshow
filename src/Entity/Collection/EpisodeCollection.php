<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    public static function findBySeasonId(int $seasonId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, seasonId, name, overview, episodeNumber
            FROM episode
            WHERE seasonId = ?
            ORDER BY episodeNumber
            SQL
        );
        $stmt ->execute([$seasonId]);
        $ep = $stmt->fetchAll(PDO::FETCH_CLASS, Episode::class);
        return $ep;
    }
}
