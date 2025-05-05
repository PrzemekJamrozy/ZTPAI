<?php

namespace App\Exceptions;

use Exception;

class UserOnboardingAlreadyFinishedException extends Exception {

    public function __construct($message = "User has already finished onboarding", $code = 409, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
}
