<?php

namespace App\Http\Controllers;

use App\Domain\Dto\User\Input\UserOnboardingInput;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Domain\Services\UserService;
use App\Exceptions\UserOnboardingAlreadyFinishedException;
use App\Helpers\ResponseHelper;
use App\Resources\DeletedModelResource;
use App\Resources\User\UserProfileResource;
use App\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="User",
 *     description="Endpoints related to user"
 * )
 */
class UserController extends Controller {

    public function __construct(
        protected UserService $userService
    ) {
    }

    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     summary="Allows to login to service",
     *     tags={"User"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(ref="#/components/schemas/UserUpdateDto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns user with updated schema",
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
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function update(Request $request, int $userId) {
        $user = $this->userService->updateUser(
            Auth::user(),
            $userId,
            UserUpdateDto::from($request->all())
        );

        return ResponseHelper::success(UserResource::from($user));
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     summary="Allows user to delete its account",
     *     tags={"User"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Return id of deleted user",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(ref="#/components/schemas/DeletedModelResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function destroy(Request $request, int $userId): JsonResponse {
        $user = $this->userService->deleteUser(
            Auth::user(),
            $userId,
        );

        return ResponseHelper::success(new DeletedModelResource($user->id));
    }

    /**
     * @OA\Post(
     *     path="/api/user/onboarding",
     *     summary="Finish user registration",
     *     tags={"User"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"bio", "fbLink", "igLink", "preferredGender", "avatar"},
     *              ref="#/components/schemas/UserOnboardingInput"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Return data of user",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/UserResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=409, description="User already finished onboarding"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function finishUserOnboarding(Request $request): JsonResponse {
        $user = $this->userService->finishUserOnboarding(
            Auth::user(),
            UserOnboardingInput::from($request->all())
        );

        return ResponseHelper::success(UserResource::from($user));
    }

}
