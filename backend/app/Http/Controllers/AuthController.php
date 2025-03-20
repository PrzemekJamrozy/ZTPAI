<?php

namespace App\Http\Controllers;

use App\Domain\Dto\Auth\Input\LoginDto;
use App\Domain\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function login(Request $request):JsonResponse{
        $result = $this->authService->login(
            LoginDto::from($request->all())
        );

        return $result->toResponse($request);
    }

    public function register(Request $request){

    }

    public function logout(Request $request){

    }
}
