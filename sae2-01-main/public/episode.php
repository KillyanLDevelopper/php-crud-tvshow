<?php

use Entity\Exception\EntityNotFoundException;
use Html\WebPage;
use Entity\Collection\EpisodeCollection;
use Entity\Season;
use Entity\TvShow;
use Entity\Poster;

try {
    if (!isset($_GET["seasonId"]) || !ctype_digit($_GET["seasonId"])) {
        header("Location: /index.php");
        exit();
    }

    $seasonId = intval($_GET["seasonId"]);
    $season = Season::findById($seasonId);
    $tvShow = TvShow::findById($season->getTvShowId());
    $episodes = EpisodeCollection::findBySeasonId($seasonId);

    $webpage = new WebPage("{$tvShow->getName()} - {$season->getName()}");

    $webpage->appendCssUrl("/css/episode.css");

    $webpage->appendContent("<h1>Séries TV : {$tvShow->getName()}</h1>");
    $webpage->appendContent("<h2>{$season->getName()}</h2>");
    $webpage->appendContent("<div class = 'button'>");
    $webpage->appendContent("<span><a class = 'home' href='tvShow.php?tvShowId={$tvShow->getId()}'>Retour</a></span>");
    $webpage->appendContent("<span><a class = 'home' href='index.php'>Home</a></span></div>");
    $poster = Poster::findById($season->getPosterId());
    $webpage->appendContent("<section class='season-info'>");
    $webpage->appendContent("<img class='season-poster' src='poster.php?PosterId={$poster->getId()}' alt='Poster de la saison' />");
    $webpage->appendContent("<div class='season-details'>");
    $webpage->appendContent("<a href = '{$tvShow->getHomePage()}'><h3>{$tvShow->getName()}</h3></a>");
    $webpage->appendContent("<p>{$season->getName()}</p>");
    $webpage->appendContent("</div>");
    $webpage->appendContent("</section>");

    // Ajouter les épisodes
    $webpage->appendContent("<section class='episodes'>");

    foreach ($episodes as $episode) {
        if ($episode instanceof \Entity\Episode) {
            $webpage->appendContent("<div class='episode'>");
            $webpage->appendContent("<h4>Numéro Episode {$episode->getepisodeNumber()} - {$episode->getName()}</h4>");
            $webpage->appendContent("<p>{$episode->getOverview()}</p>");
            $webpage->appendContent("</div>");
        }
    }

    $webpage->appendContent("</section>");


    echo $webpage->toHTML();

} catch (EntityNotFoundException $e) {
    http_response_code(404);
    echo "Erreur : " . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur : " . $e->getMessage();
}
