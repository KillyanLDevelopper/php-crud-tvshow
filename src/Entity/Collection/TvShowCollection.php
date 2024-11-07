<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\TvShow;
use Html\WebPage;
use PDO;

class TvShowCollection
{
    /** @return TvShow[] */
    public static function findAll(): array
    {
        $webpage = new WebPage("Séries TV");
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage,overview,posterId
            FROM tvshow
            ORDER BY name
        SQL
        );

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, TvShow::class);
    }

    public static function findbyIdGenre($genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT tv.id, tv.name, tv.originalName, tv.homepage, tv.overview, tv.posterId
        FROM tvshow tv
        JOIN tvshow_genre tg ON tv.id = tg.tvShowId
        WHERE tg.genreId = :genreId
        ORDER BY tv.name
        SQL
        );
        $stmt->execute([':genreId' => $genreId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, TvShow::class);
    }
}
