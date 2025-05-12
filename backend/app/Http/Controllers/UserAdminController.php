<?php

namespace App\Http\Controllers;

use App\Domain\Dto\User\Input\UserAdminUpdateDto;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Domain\Services\AdminUserService;
use App\Helpers\ResponseHelper;
use App\Resources\DeletedModelResource;
use App\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="UserAdmin",
 *     description="Endpoints related to user admin"
 * )
 */
class UserAdminController extends Controller {
    public function __construct(
        protected AdminUserService $userService
    ) {

    }

    /**
     * @OA\Get (
     *     path="/admin/user",
     *     summary="Allows admin to get list of users",
     *     tags={"UserAdmin"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns list of users",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function index() {
        $users = $this->userService->getUsers(
            Auth::user()
        );

        return ResponseHelper::success(UserResource::collect($users));
    }

    /**
     * @OA\Get (
     *     path="/admin/user/{userId}",
     *     summary="Allows admin to get user by id",
     *     tags={"UserAdmin"},
     *     @OA\Response(
     *         response=200,
     *         description="Returns user of given id",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/UserResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function show(Request $request, int $userId) {
        $user = $this->userService->getUser(Auth::user(), $userId);

        return ResponseHelper::success(UserResource::from($user));
    }

    public function update(Request $request, int $userId) {
        $user = $this->userService->updateUser(
            Auth::user(),
            $userId,
            UserAdminUpdateDto::from($request->all())
        );

        return ResponseHelper::success(UserResource::from($user));
    }

    public function destroy(Request $request, int $userId) {
        $this->userService->deleteUser(
            Auth::user(),
            $userId,
        );
        return ResponseHelper::success(new DeletedModelResource($userId));
    }

}
