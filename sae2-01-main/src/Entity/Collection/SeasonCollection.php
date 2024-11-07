<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;
use Html\WebPage;
use PDO;

class SeasonCollection
{
    public static function findByTvShowId(int $tvShowId): array
    {
        $webpage = new WebPage("Season");
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM season
            where tvShowId = ?
            ORDER BY seasonNumber
        SQL
        );

        $stmt->execute([$tvShowId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Season::class);
    }
}
