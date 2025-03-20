<?php

namespace App\Domain\Dto\Auth\Input;

use Spatie\LaravelData\Data;

class LoginDto extends Data {

    public string $email;
    public string $password;

}
