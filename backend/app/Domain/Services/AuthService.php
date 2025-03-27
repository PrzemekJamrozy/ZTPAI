<?php

namespace App\Domain\Services;

use App\Domain\Actions\UserActions;
use App\Domain\Dto\Auth\Input\LoginDto;
use App\Domain\Dto\Auth\Input\LogoutDto;
use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Models\User;
use App\Resources\Auth\TokenResource;
use Illuminate\Http\Request;

class AuthService {


    public function __construct(
        protected UserActions $userActions
    ) {
    }

    public function login(LoginDto $loginDto): TokenResource {


    }

    public function register(RegisterDto $registerDto):User {
        $user = $this->userActions->createUser($registerDto);
        return $user;
    }

    public function logout(LogoutDto $logoutDto) {

    }
}
