<?php

declare(strict_types=1);

use Entity\TvShow;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\WebPage;

try {
    if (isset($_GET['tvShowId'])) {
        if(!ctype_digit($_GET['tvShowId'])) {
            throw new ParameterException("Ce n'est pas un id de serie TV");
        }
    } else {
        http_response_code(400);
    }

    $tvshow = \Entity\TvShow::findById(intval($_GET['tvShowId']));
    $tvshow->delete();

    header('Location: /');
    http_response_code(302);




} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
