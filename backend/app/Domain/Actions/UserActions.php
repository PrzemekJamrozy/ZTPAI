<?php

namespace App\Domain\Actions;

use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Domain\Dto\User\Input\UserAdminUpdateDto;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Enums\Roles;
use App\Enums\UserStatus;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Optional;

class UserActions {

    public function createUser(RegisterDto $dto): User {
        $user = new User();
        $user->status = USerStatus::DURING_REGISTRATION;
        $user->password = Hash::make($dto->password);
        $user->assignRole(Roles::USER->value);
        $user->fill($dto->all());
        $user->save();
        return $user;
    }

    public function updateUser(User $user, UserUpdateDto|UserAdminUpdateDto $dto): User {
        if(!($dto->password instanceof Optional)) {
            $user->password = Hash::make($dto->password);
        }

        if($dto->role){
            $user->removeRole($user->getRoleNames()[0]);
            $user->assignRole($dto->role);
        }

        $user->fill($dto->all());
        $user->save();
        return $user;
    }

    public function deleteUser(User $user): User {
        $user->tokens()->delete();
        $user->profile?->delete();
        $user->matches()->each(fn(UserMatch $match) => $match->delete());
        $user->delete();
        return $user;
    }


    public function changeUserStatus(User $user, UserStatus $status): User {
        $user->status = $status;
        $user->save();
        return $user;
    }

}
