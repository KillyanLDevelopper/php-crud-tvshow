<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Entity\TvShow;
use Html\Form\TvShowForm;

try {

    if (!isset($_POST['tvShowId'])) {
        $tvShow = null;
    } else {
        if (!ctype_digit($_POST['tvShowId'])) {
            throw new ParameterException("Ce n'est pas un id de serie TV");
        }

        $tvShow = TvShow::findById(intval($_POST['tvShowId']));
    }
    $tvShowForm = new TvShowForm($tvShow);
    $tvShowForm->setEntityFromQueryString();
    $tvShow = $tvShowForm->getTvShow();
    $tvShow->save();
    header('Location: /');
    http_response_code(302);

} catch (ParameterException $e) {
    http_response_code(400);
    echo "Erreur de paramètre: " . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur interne du serveur: " . htmlspecialchars($e->getMessage()) . "<br>";
    echo nl2br(htmlspecialchars($e->getTraceAsString()));
}
