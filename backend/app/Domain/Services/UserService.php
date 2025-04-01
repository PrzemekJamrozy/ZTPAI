<?php

namespace App\Domain\Services;

use App\Domain\Actions\UserActions;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Exceptions\ModelNotFoundException;
use App\Models\User;
use App\Repositories\UserQuery;
use Illuminate\Support\Facades\Auth;

class UserService {


    public function __construct(
        protected UserActions $userActions,
    ) {
    }

    public function getUser(User $currentUser, int $userId):User {
        $user = UserQuery::create()
            ->find($userId);

        if(!$user || $user->id !== $currentUser->id) {
            throw new ModelNotFoundException();
        }

        return $user;
    }

    public function updateUser(User $currentUser, int $userId, UserUpdateDto $updateInput):User {
        $user = UserQuery::create()
            ->find($userId);

        if(!$user || $user->id !== $currentUser->id) {
            throw new ModelNotFoundException();
        }

        $user = $this->userActions->updateUser($currentUser, $updateInput);

        return $user;
    }

    public function deleteUser(User $currentUser, int $userId):User {
        $user = UserQuery::create()
            ->find($userId);

        if(!$user || $user->id !== $currentUser->id) {
            throw new ModelNotFoundException();
        }

        $this->userActions->deleteUser($currentUser);

        return $user;
    }
}
