<?php

namespace App\Domain\Actions;

use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserActions {

    public function createUser(RegisterDto $dto): User {
        $user = new User();
        $user->status = USerStatus::DURING_REGISTRATION;
        $user->password = Hash::make($dto->password);
        $user->fill($dto->all());
        return $user;
    }
}
