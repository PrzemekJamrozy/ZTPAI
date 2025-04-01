<?php

namespace App\Resources\User;

use App\Enums\GenderEnum;
use App\Enums\UserStatus;
use Spatie\LaravelData\Data;

class UserResource extends Data {

    public int $id;
    public string $name;
    public string $surname;
    public string $email;
    public UserStatus $status;
    public GenderEnum $gender;

}
