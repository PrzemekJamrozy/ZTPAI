<?php

namespace App\Http\Controllers;

use App\Domain\Services\AdminUserService;
use App\Helpers\ResponseHelper;
use App\Resources\User\UserResource;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function __construct(
        protected AdminUserService $userService
    ){

    }

    public function index(){
        $users = $this->userService->getUsers();

        return ResponseHelper::success(UserResource::collect($users));
    }

    public function show(Request $request, int $userId){
        $user = $this->userService->getUser($userId);

        return ResponseHelper::success(UserResource::from($user));
    }
}
