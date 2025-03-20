<?php

namespace App\Domain\Dto\Auth\Input;

use App\Enums\GenderEnum;
use Spatie\LaravelData\Data;

class RegisterDto extends Data {

    public string $name;
    public string $surname;
    public string $email;
    public string $password;
    public GenderEnum $gender;
}
