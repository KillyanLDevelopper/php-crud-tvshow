<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Html\WebPage;
use Entity\TvShow;
use Entity\Poster;

try {
    if (!isset($_GET["tvShowId"]) || !ctype_digit($_GET["tvShowId"])) {
        header("Location: /index.php");
        exit();
    }

    $tvShowId = intval($_GET["tvShowId"]);
    $tvShow = TvShow::findById((int)$tvShowId);
    $webpage = new WebPage("{$tvShow->getName()}");
    $webpage->appendContent("<h1> Séries TV {$tvShow->getName()} </h1>");
    $webpage->appendCssUrl("/css/tvShow.css");
    $webpage->appendContent("");
    $seasons = $tvShow->getSeasons();
    $webpage->appendContent("<div class='home'><span><a class = 'home' href='index.php'>Home</a></span>");
    $webpage->appendContent("<span class='home'><a href='admin/tvShow-form.php?tvShowId={$tvShowId}'>Modifier</a></span>");
    $webpage->appendContent("<span class='home'><a href='admin/tvShow-delete.php?tvShowId={$tvShowId}'>Supprimer</a></span></div>");
    $webpage->appendContent("<section class='content'>
<div class='list'>");
    $webpage->appendContent(<<<HTML
    <div class='serie'>
            <img class='serie__poster' alt='serie' src='poster.php?PosterId={$tvShow->getPosterId()}'/>
            <div class='serie__css'>
                <span class='serie__name'>{$webpage->escapeString($tvShow->getName())}</span>
                <span class='serie_originalName'>{$tvShow->getOriginalName()}</span>
                <span class='serie_overview'>{$tvShow->getOverview()}</span>
            </div>
        </div>  
        
HTML);
    foreach ($seasons as $season) {
        if ($season instanceof \Entity\Season) {
            $poster = Poster::findById($season->getPosterId());
            $webpage->appendContent(
                <<<HTML
            <div class='season'>
            <a href=episode.php?seasonId={$season->getId()}' class='season__poster'><img class='season__poster' alt='season' src='poster.php?PosterId={$poster->getId()}'/></a>
                <span class='season__name'><a href='episode.php?seasonId={$season->getId()}'>{$webpage->escapeString($season->getName())}</a></span>
            </div>
HTML
            );
        }
    }

    $webpage->appendContent("</div>
</section>");
    echo $webpage->toHTML();
} catch(EntityNotFoundException) {
    http_response_code(404);
}
