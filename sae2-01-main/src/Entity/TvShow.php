<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;
use Html\WebPage;
use PDO;

class TvShow
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string  $overview;
    private ?int $posterId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getHomePage(): string
    {
        return $this->homepage;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /** cherche la serie TV en fonction de l'id
     * @param int $id
     * @return TvShow
     */
    public static function findById(int $id): TvShow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            WHERE id = ?
    SQL
        );


        $stmt->execute([$id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, TvShow::class);
        $tvshow = $stmt->fetch();

        if (!$tvshow) {
            throw new EntityNotFoundException("ce n'est pas une séries TV'");
        }

        return $tvshow;
    }

    /** récupère toutes les saisons de la series tv
     * @return array
     */
    public function getSeasons(): array
    {

        return SeasonCollection::findByTvShowId($this->getId());
    }
    public function delete(): self
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            DELETE FROM tvshow
            WHERE id = ?;
            SQL
        );
        $stmt->execute([$this->id]);

        $this->id = null;
        return $this;
    }

    /** insertion d'une séries TV
     * @return $this
     */
    protected function insert(): self
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            INSERT INTO tvshow (id, name, originalName, homepage, overview)
            values (:id, :name, :originalName, :homepage, :overview);
    SQL
        );
        $stmt->execute(["name" => $this->name , "id" => $this->id, "originalName" => $this->originalName, "homepage" => $this->homepage, "overview" => $this->overview]);

        $this->id = intval(MyPdo::getInstance()->lastInsertId());

        return $this;
    }

    /** Modificateur d'une series TV
     * @return $this
     */
    protected function update(): self
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
        UPDATE tvshow SET name = :name, originalName = :originalName, homepage = :homepage, overview = :overview WHERE id = :id;
SQL
        );
        $stmt->execute([
            "name" => $this->name,
            "originalName" => $this->originalName,
            "homepage" => $this->homepage,
            "overview" => $this->overview,
            "id" => $this->id
        ]);

        return $this;
    }

    /** crée une séries tv
     * @param $name
     * @param $originalName
     * @param $homepage
     * @param $overview
     * @param int|null $id
     * @return self
     */
    public static function create($name, $originalName, $homepage, $overview, ?int $id = null): self
    {
        $tvshow = new TvShow();
        $tvshow->setName($name);
        $tvshow->setId($id);
        $tvshow->setOriginalName($originalName);
        $tvshow->setHomepage($homepage);
        $tvshow->setOverview($overview);
        return $tvshow;
    }

    /** enregistre la documentation ou la création
     * @return $this
     */
    public function save(): self
    {
        if ($this->id == null) {
            $this->insert();
        } else {
            $this->update();
        }

        return $this;

    }
    private function __construct()
    {
    }
}
