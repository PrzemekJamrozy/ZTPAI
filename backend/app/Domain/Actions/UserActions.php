<?php

namespace App\Domain\Actions;

use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Enums\Permissions;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Optional;

class UserActions {

    public function createUser(RegisterDto $dto): User {
        $user = new User();
        $user->status = USerStatus::DURING_REGISTRATION;
        $user->password = Hash::make($dto->password);
        $user->assignRole(Permissions::USER->value);
        $user->fill($dto->all());
        $user->save();
        return $user;
    }

    public function updateUser(User $user, UserUpdateDto $dto): User {
        if(!($dto->password instanceof Optional)) {
            $user->password = Hash::make($dto->password);
        }
        $user->fill($dto->all());
        $user->save();
        return $user;
    }

    public function deleteUser(User $user): User {
        $user->tokens()->delete();
        $user->delete();
        return $user;
    }


    public function changeUserStatus(User $user, UserStatus $status): User {
        $user->status = $status;
        $user->save();
        return $user;
    }

}
