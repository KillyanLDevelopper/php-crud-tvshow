<?php

namespace Entity;

class Episode
{
    private int $id;

    private int $seasonId;

    private string $name;

    private string $overview;

    private int $episodeNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getoverview(): string
    {
        return $this->overview;
    }

    public function getepisodeNumber(): int
    {
        return $this->episodeNumber;
    }


}
