<?php

namespace App\Domain\Dto\User\Input;

use App\Enums\GenderEnum;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserUpdateDto extends Data {

    public string|Optional $name;
    public string|Optional $surname;

    #[Unique('users','email')]
    #[Email]
    public string|Optional $email;
    public string|Optional $password;
    public GenderEnum|Optional $gender;

}
