<?php

declare(strict_types=1);

namespace Entity\Exception;

use Exception;

class ParameterException extends Exception
{
    public function __construct($message = "Parameter error", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
