<?php

namespace App\Domain\Actions;


use App\Domain\Dto\Auth\Input\LoginDto;
use App\Models\User;

class AuthActions {

    public function login(User $user): string {
        $token = $user->createToken("TOKEN-$user->email");

        return $token->plainTextToken;
    }

    public function logout(User $user): void {
        $user->tokens()->delete();
    }
}
