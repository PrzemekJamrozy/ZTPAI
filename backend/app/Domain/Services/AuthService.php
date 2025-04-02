<?php

namespace App\Domain\Services;

use App\Domain\Actions\AuthActions;
use App\Domain\Actions\UserActions;
use App\Domain\Dto\Auth\Input\LoginDto;
use App\Domain\Dto\Auth\Input\LogoutDto;
use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use App\Repositories\UserQuery;
use App\Resources\Auth\TokenResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService {


    public function __construct(
        protected UserActions $userActions,
        protected AuthActions $authActions,
    ) {
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function login(LoginDto $loginDto): TokenResource {
        if (!Auth::attempt(['email' => $loginDto->email, 'password' => $loginDto->password])) {
            throw new InvalidCredentialsException();
        }

        $user = UserQuery::create()
            ->whereEmail($loginDto->email)
            ->first();


        // In order to not have many tokens in DB we first remove all tokens than create a new one
        $this->authActions->logout($user);
        $generatedToken = $this->authActions->login($user);

        return TokenResource::from(["token" => $generatedToken]);
    }

    public function register(RegisterDto $registerDto): User {
        $user = $this->userActions->createUser($registerDto);
        return $user;
    }

    public function logout():User {
        /** @var User $user */
        $user = Auth::user();
        $this->authActions->logout($user);
        return $user;
    }
}
