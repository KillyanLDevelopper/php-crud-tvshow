<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use Entity\TvShow;
use Html\WebPage;
use PDO;

class GenreCollection
{
    /** @return Genre[] */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name
            FROM genre
            ORDER BY name
        SQL
        );

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }

}
