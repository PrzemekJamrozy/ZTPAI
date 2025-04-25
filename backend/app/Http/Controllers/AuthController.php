<?php

namespace App\Http\Controllers;

use App\Domain\Dto\Auth\Input\LoginDto;
use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Domain\Services\AuthService;
use App\Exceptions\InvalidCredentialsException;
use App\Helpers\ResponseHelper;
use App\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function __construct(
        protected AuthService $authService
    ) {
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function login(Request $request): JsonResponse {
        $result = $this->authService->login(
            LoginDto::from($request->all())
        );

        return ResponseHelper::success($result);
    }

    public function register(Request $request): JsonResponse {
        $result = $this->authService->register(
            RegisterDto::from($request->all())
        );

        return ResponseHelper::success(["message" => "User registered successfully"]);
    }

    public function logout(Request $request): JsonResponse {
        $user = $this->authService->logout();

        return ResponseHelper::success(["message" => "Logged out"]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse {
        $user = $this->authService->me(
            Auth::user()
        );

        return ResponseHelper::success(UserResource::from($user));
    }

}
