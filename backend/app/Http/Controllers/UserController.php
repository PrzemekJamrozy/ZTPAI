<?php

namespace App\Http\Controllers;

use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Domain\Services\UserService;
use App\Helpers\ResponseHelper;
use App\Resources\DeletedModelResource;
use App\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function __construct(
        protected UserService $userService
    ) {
    }

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
