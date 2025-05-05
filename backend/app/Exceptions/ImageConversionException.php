<?php

namespace App\Exceptions;

use Exception;

class ImageConversionException extends Exception {


    public function __construct($message = "Unable to decode image", $code = 422, ?Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
