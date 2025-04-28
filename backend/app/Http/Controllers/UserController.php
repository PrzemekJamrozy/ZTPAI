<?php

namespace App\Http\Controllers;

use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Domain\Services\UserService;
use App\Helpers\ResponseHelper;
use App\Resources\DeletedModelResource;
use App\Resources\User\UserResource;
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
     *     path="/api/user",
     *     summary="Allows to login to service",
     *     tags={"User"},
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

    public function destroy(Request $request, int $userId) {
        $user = $this->userService->deleteUser(
            Auth::user(),
            $userId,
        );

        return ResponseHelper::success(new DeletedModelResource($user->id));
    }

}
