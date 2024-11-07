<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\TvShow;
use Entity\Exception\ParameterException;
use Html\StringEscaper;

class TvShowForm
{
    use StringEscaper;
    private ?TvShow  $tvShow;

    /**
     * @param TvShow|null $tvShow
     */
    public function __construct(?TvShow $tvShow = null)
    {
        $this->tvShow = $tvShow;
    }
    /**
     * @return TvShow|null
     */
    public function getTvShow(): ?TvShow
    {
        return $this->tvShow;
    }
    public function getHtmlForm(string $action): string
    {
        $id = $this->tvShow?->getId() ?? '';
        $name = $this->escapeString($this->stripTagsAndTrim($this->tvShow?->getName() ?? ''));
        $originalName = $this->escapeString($this->stripTagsAndTrim($this->tvShow?->getOriginalName() ?? ''));
        $homepage = $this->escapeString($this->stripTagsAndTrim($this->tvShow?->getHomePage() ?? ''));
        $overview = $this->escapeString($this->stripTagsAndTrim($this->tvShow?->getOverview() ?? ''));
        $stmt = <<<HTML
<form action="{$action}" method="post"> 
<input type="hidden" name="id" value="{$id}">
    <label>
        Nom
        <input type="text" id="name" name="name" value="{$name}" required>
    </label>
    <label>
        Nom original
        <input type="text" id="originalName" name="originalName" value="{$originalName}" required>
    </label>
    <label>
        Page d'acceuil
        <input type="text" id="homepage" name="homepage" value="{$homepage}" required>
    </label>
    <label>
        Description
        <input type="text" id="overview" name="overview" value="{$overview}" required>
    </label>
    <button type="submit">Enregistrer</button>
</form>
HTML;
        return $stmt;
    }

    public function setEntityFromQueryString(): void
    {
        if (!isset($_POST["name"]) || empty($_POST["name"])) {
            throw new ParameterException("Le nom de la série est null");
        }

        if (!isset($_POST["originalName"]) || empty($_POST["originalName"])) {
            throw new ParameterException("Le nom original de la série est null");
        }

        if (!isset($_POST["homepage"]) || empty($_POST["homepage"])) {
            throw new ParameterException("Le lien n'existe pas");
        }

        if (!isset($_POST["overview"]) || empty($_POST["overview"])) {
            throw new ParameterException("La description de la série est null");
        }

        if (!isset($_POST["id"]) || empty($_POST["id"])) {
            $id = null;
        } else {
            $id = (int)$_POST["id"];
        }
        $originalName = $this->escapeString($this->stripTagsAndTrim($_POST["originalName"]));
        $overview = $this->escapeString($this->stripTagsAndTrim($_POST["overview"]));
        $homepage = $this->escapeString($this->stripTagsAndTrim($_POST["homepage"]));
        $name = $this->escapeString($this->stripTagsAndTrim($_POST["name"]));
        $tvShow = TvShow::create($name, $originalName, $homepage, $overview, $id);
        $this->tvShow = $tvShow;
    }
}
