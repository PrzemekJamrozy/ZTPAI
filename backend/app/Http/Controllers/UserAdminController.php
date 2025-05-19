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
     *     path="/api/admin/users",
     *     summary="Allows admin to get list of users",
     *     tags={"UserAdmin"},
     *     security={{"sanctum":{}}},
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
     *     @OA\Response(response=401, description="Invalid credentials or not authorized"),
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
     *     path="/api/admin/users/{userId}",
     *     summary="Allows admin to get user by id",
     *     tags={"UserAdmin"},
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
     *     @OA\Response(response=401, description="Invalid credentials or not authorized"),
     *     @OA\Response(response=422, description="Invalid body"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function show(Request $request, int $userId) {
        $user = $this->userService->getUser(Auth::user(), $userId);

        return ResponseHelper::success(UserResource::from($user));
    }

    /**
     * @OA\Put(
     *     path="/api/admin/users/{id}",
     *     summary="Allows admin to update user",
     *     tags={"UserAdmin"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID of the user",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/UserResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials or not authorized"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */

    public function update(Request $request, int $userId) {
        $user = $this->userService->updateUser(
            Auth::user(),
            $userId,
            UserAdminUpdateDto::from($request->all())
        );

        return ResponseHelper::success(UserResource::from($user));
    }

    /**
     * @OA\Delete  (
     *     path="/api/admin/users/{id}",
     *     summary="Allows admin to delete user",
     *     tags={"UserAdmin"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID of the user",
     *           required=true,
     *           @OA\Schema(type="integer")
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns if of deleted user",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property (ref="#/components/schemas/DeletedModelResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials or not authorized"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function destroy(Request $request, int $userId) {
        $this->userService->deleteUser(
            Auth::user(),
            $userId,
        );
        return ResponseHelper::success(new DeletedModelResource($userId));
    }

}
