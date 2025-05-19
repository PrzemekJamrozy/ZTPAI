<?php

namespace App\Http\Controllers;

use App\Domain\Dto\Auth\Input\LoginDto;
use App\Domain\Dto\Auth\Input\RegisterDto;
use App\Domain\Services\AuthService;
use App\Exceptions\InvalidCredentialsException;
use App\Helpers\ResponseHelper;
use App\Resources\User\UserResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *     title="Datespark API",
 *     version="1.0.0"
 * ),
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints related to auth"
 * )
 */
class AuthController extends Controller {

    public function __construct(
        protected AuthService $authService
    ) {
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Allows to login to service",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="example@email.com", description="Email"),
     *             @OA\Property(property="password", type="string", example="password", description="Password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns token to use later for auth",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function login(Request $request): JsonResponse {
        $result = $this->authService->login(
            LoginDto::from($request->all())
        );

        return ResponseHelper::success($result);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Allows to register user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "surname", "email", "password", "gender"},
     *             @OA\Property(property="name", type="string", example="Jan", description="Name of user"),
     *             @OA\Property(property="surname", type="string", example="Kowalski", description="Surname of user"),
     *             @OA\Property(property="email", type="string", example="example@email.com", description="Email"),
     *             @OA\Property(property="password", type="string", example="password", description="Password"),
     *             @OA\Property(property="gender", type="string", example="MALE", description="Gender of user. Value must be either MALE or FEMALE"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns message that user logout successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="message", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function register(Request $request): JsonResponse {
        $result = $this->authService->register(
            RegisterDto::from($request->all())
        );

        return ResponseHelper::success(["message" => "User registered successfully"]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Allows to logout user",
     *     tags={"Auth"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Returns token to use later for auth",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="message", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     * )
     */
    public function logout(Request $request): JsonResponse {
        $user = $this->authService->logout();

        return ResponseHelper::success(["message" => "Logged out"]);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="Get logged user",
     *     tags={"Auth"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Return data of currently logged in user",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     * )
     */
    public function me(Request $request): JsonResponse {
        $user = $this->authService->me(
            Auth::user()
        );

        return ResponseHelper::success(UserResource::from($user));
    }

}
