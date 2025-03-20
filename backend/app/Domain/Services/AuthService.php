<?php

namespace App\Domain\Services;

use App\Domain\Dto\Auth\Input\LoginDto;
use App\Domain\Dto\Auth\Input\LogoutDto;
use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Resources\Auth\TokenResource;
use Illuminate\Http\Request;

class AuthService {


    public function login(LoginDto $loginDto): TokenResource {


    }

    public function register(RegisterDto $registerDto) {

    }

    public function logout(LogoutDto $logoutDto) {

    }
}
