<?php

declare(strict_types=1);


use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Html\AppWebPage;
use Html\WebPage;
use Entity\Collection\TvShowCollection;
use Entity\TvShow;

// Afficher tous les genres
$WebPage = new \Html\AppWebPage("Serie TV");
$series = TvShowCollection::findAll();
$genres =  GenreCollection::findAll();

$WebPage->appendContent('<div class="fixed-genres">');

$WebPage->appendContent("
    <span><a href='index.php'>Tous</a></span>
");




foreach($genres as $genre) {
    $nameGenre = $genre->getName();
    $idGenre = $genre->getId();
    $WebPage->appendContent("
<span><a href='index.php?GenreId=$idGenre'>$nameGenre</a></span>
");
}
$WebPage->appendContent('</div>');

$WebPage->appendContent("<div>");
$WebPage->appendContent("<span><a class ='ajouter' href='admin/tvShow-form.php'>Ajouter</a></span></div>");

$WebPage->appendContent("<section class='content'>");

$GenreId = isset($_GET['GenreId']) ? (int)$_GET['GenreId'] : null;

if ($GenreId) {
    foreach ($genres as $genre) {
        if ($genre->getId() === $GenreId) {
            $WebPage->appendContent("<h1 style ='align-content: center'>{$genre->getName()}</h1>");
        }
    }


    // Récupérer les séries du genre sélectionné
    $seriesGenre = TvShowCollection::findbyIdGenre($GenreId);
    foreach ($seriesGenre as $serie) {
        $name = $serie->getName();
        $Posterid = $serie->getPosterId();
        $overview = $serie->getOverview();
        $link = "tvShow.php?tvShowId={$serie->getId()}";
        $img = "<img class='serie__cover' src='poster.php?PosterId=$Posterid' alt='image'/>";
        $WebPage->appendContent("<section class='serie'>
            <div class='serie__cover'><a href=\"$link\" class='serie__cover'>$img</a></div>
            <div class='text'>
            <span class='serie__name'><a class='serie__name' href=\"$link\">$name</a></span> 
            <span class='serie__overview'>$overview</span>
            </div>
        </section>");
    }
} else {
    // Afficher toutes les séries si aucun genre n'est sélectionné
    foreach ($series as $serie) {
        $name = $serie->getName();
        $Posterid = $serie->getPosterId();
        $overview = $serie->getOverview();
        $link = "tvShow.php?tvShowId={$serie->getId()}";
        $img = "<img class='serie__cover' src='poster.php?PosterId=$Posterid' alt='image'/>";
        $WebPage->appendContent("<section class='serie'>
            <div class='serie__cover'><a href=\"$link\" class='serie__cover'>$img</a></div>
            <div class='text'>
            <span class='serie__name'><a class='serie__name' href=\"$link\">$name</a></span> 
            <span class='serie__overview'>$overview</span>
            </div>
        </section>");
    }
}

$WebPage->appendContent("</section>");
echo $WebPage->toHTML();
