<?php

namespace App\Domain\Services;

use App\Domain\Actions\UserActions;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Enums\Permissions;
use App\Models\User;
use App\Repositories\UserQuery;
use Illuminate\Support\Collection;

class AdminUserService {


    public function __construct(
        protected UserActions $userActions
    ) {
    }

    public function getUsers(): Collection {
        $users = UserQuery::create()->get();
        return $users;
    }


    public function getUser(int $userId): User {
        $user = UserQuery::create()->find($userId);
        return $user;
    }

    public function updateUser(int $userId, UserUpdateDto $dto): User {
        $user = UserQuery::create()->find($userId);

        $this->userActions->updateUser($user, $dto);
        return $user;
    }

    public function deleteUser(int $userId): User {
        $user = UserQuery::create()->find($userId);

        $this->userActions->deleteUser($user);
        return $user;
    }

    public function getRoles():Collection {
        return collect(Permissions::cases());
    }
}
