<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;

    private string $jpeg;



    public function getId(): int
    {
        return $this->id;
    }

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /** trouve les posters en fonction de l'id
     * @param $id
     * @return Poster
     */
    public static function findById($id): Poster
    {
        $stmt = MYPDO::getInstance()->prepare(
            <<<'SQL'
                SELECT id,jpeg
                FROM poster
                WHERE id = ?
                SQL
        );

        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $poster = $stmt->fetch();


        if (!$poster) {
            throw new EntityNotFoundException("Le poster avec l'id  $id n'a pas été trouvé");

        }
        return $poster;

    }
}
