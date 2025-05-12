<?php

namespace App\Exceptions;

use Exception;

class UserNotAuthorized extends Exception {

    public function __construct($message = "User cannot perform this action", $code = 401, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }

}
