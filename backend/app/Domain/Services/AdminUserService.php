<?php

namespace App\Domain\Services;

use App\Domain\Actions\UserActions;
use App\Domain\Actions\UserProfileActions;
use App\Domain\Dto\User\Input\UserAdminUpdateDto;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Enums\Roles;
use App\Models\User;
use App\Repositories\UserQuery;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminUserService {


    public function __construct(
        protected UserActions        $userActions,
        protected UserProfileActions $profileActions
    ) {
    }

    public function getUsers(): Collection {
        $users = UserQuery::create()
            ->loadRelation("profile")
            ->loadRelation("roles")
            ->get();
        return $users;
    }


    public function getUser(int $userId): User {
        $user = UserQuery::create()
            ->loadRelation("profile")
            ->loadRelation("roles")
            ->find($userId);
        return $user;
    }

    public function updateUser(int $userId, UserAdminUpdateDto $dto): User {
        $user = UserQuery::create()
            ->loadRelation("profile")
            ->loadRelation("roles")
            ->find($userId);

        $user = DB::transaction(function () use ($user, $dto) {
            $this->userActions->updateUser($user, $dto);
            $this->profileActions->updateUserProfile($dto->profile, $user->profile);

            return $user;
        });


        return $user;
    }

    public function deleteUser(int $userId): User {
        $user = UserQuery::create()->find($userId);

        $this->userActions->deleteUser($user);
        return $user;
    }

    public function getRoles(): Collection {
        return collect(Roles::cases());
    }
}
