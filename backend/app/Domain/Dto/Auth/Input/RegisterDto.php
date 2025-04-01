<?php

namespace App\Domain\Dto\Auth\Input;

use App\Enums\GenderEnum;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class RegisterDto extends Data {

    public string $name;
    public string $surname;

    #[Unique('users','email')]
    #[Email]
    public string $email;
    public string $password;
    public GenderEnum $gender;
}
