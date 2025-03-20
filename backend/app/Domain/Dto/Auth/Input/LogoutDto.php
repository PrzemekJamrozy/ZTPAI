<?php

namespace App\Domain\Dto\Auth\Input;

use Spatie\LaravelData\Data;

class LogoutDto extends Data {

    public string $token;
}
