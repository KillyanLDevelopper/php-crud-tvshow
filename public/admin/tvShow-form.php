<?php

declare(strict_types=1);


use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\TvShow;
use Html\Form\TvShowForm;
use Html\WebPage;

try {
    $webpage = new WebPage("Formulaire de série TV");
    if (!isset($_GET['tvShowId'])) {
        $tvshow = null;
    } else {
        if (!ctype_digit($_GET['tvShowId'])) {
            throw new ParameterException("Ce n'est pas un id de série TV");
        }

        $tvshow = TvShow::findById((int)($_GET['tvShowId']));
    }

    $tvShowForm = new TvShowForm($tvshow);
    $webpage->appendContent($tvShowForm->getHtmlForm("tvShow-save.php"));
    $webpage->appendCssUrl("/css/form.css");
    $webpage->appendToHead("<h1> Formulaire </h1>");

    echo $webpage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
