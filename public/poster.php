<?php

declare(strict_types=1);

use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if (isset($_GET['PosterId']) || empty($_GET['PosterId'])) {
        header('Content-Type : image/png');
        header('Location :img/default.png');
    }

    if (!isset($_GET['PosterId'])) {
        throw new ParameterException("L'identifiant de la pochette est manquant.");
    }

    $id = $_GET['PosterId'];

    if (!is_numeric($id)) {
        throw new ParameterException("L'identifiant de la pochette doit être un nombre.");
    }

    $poster = Poster::findById($id);

    header('Content-Type: image/jpeg');
    echo $poster->getJpeg();

} catch (ParameterException $e) {
    http_response_code(400);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
} catch (Exception $e) {
    http_response_code(500);

}
