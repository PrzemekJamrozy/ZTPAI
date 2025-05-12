<?php

namespace App\Domain\Services;

use App\Domain\Actions\UserActions;
use App\Domain\Actions\UserProfileActions;
use App\Domain\Dto\User\Input\UserOnboardingInput;
use App\Domain\Dto\User\Input\UserUpdateDto;
use App\Enums\UserStatus;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\UserOnboardingAlreadyFinishedException;
use App\Models\User;
use App\Models\UserProfile;
use App\Repositories\UserQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService {


    public function __construct(
        protected UserActions $userActions,
        protected UserProfileActions $userProfileActions,
    ) {
    }

    public function getUser(User $currentUser, int $userId):User {
        $user = UserQuery::create()
            ->loadRelation("profile")
            ->loadRelation("roles")
            ->find($userId);

        if(!$user || $user->id !== $currentUser->id) {
            throw new ModelNotFoundException();
        }

        return $user;
    }

    public function updateUser(User $currentUser, int $userId, UserUpdateDto $updateInput):User {
        $user = UserQuery::create()
            ->loadRelation("profile")
            ->loadRelation("roles")
            ->find($userId);

        if(!$user || $user->id !== $currentUser->id) {
            throw new ModelNotFoundException();
        }

        $user = DB::transaction(function () use ($updateInput, $currentUser) {
            $user = $this->userActions->updateUser($currentUser, $updateInput);
            $this->userProfileActions->updateUserProfile($updateInput->profile, $currentUser->profile);
            return $user;
        });

        return $user;
    }

    public function deleteUser(User $currentUser, int $userId):User {
        $user = UserQuery::create()
            ->find($userId);

        if(!$user || $user->id !== $currentUser->id) {
            throw new ModelNotFoundException();
        }

        DB::transaction(function () use ($currentUser) {
            $this->userActions->deleteUser($currentUser);
        });

        return $user;
    }

    public function finishUserOnboarding(User $currentUser, UserOnboardingInput $input): User {

        if($currentUser->profile !== null){
            throw new UserOnboardingAlreadyFinishedException();
        }

        $result = DB::transaction(function () use ($currentUser, $input) {
            $result = $this->userProfileActions->createUserProfile($currentUser, $input);
            $this->userActions->changeUserStatus($currentUser, UserStatus::ACTIVE);
            return $result;
        });
        $currentUser->load("profile");

        return $currentUser;
    }
}
