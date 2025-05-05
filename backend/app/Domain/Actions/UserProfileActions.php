<?php

namespace App\Domain\Actions;

use App\Domain\Dto\User\Input\UserOnboardingInput;
use App\Helpers\ImageHelper;
use App\Models\User;
use App\Models\UserProfile;

class UserProfileActions {


    public function __construct(
        protected ImageHelper $imageHelper,
    ) {
    }

    public function createUserProfile(User $user, UserOnboardingInput $input): UserProfile {
        $userProfile = new UserProfile();
        $userProfile->user_id = $user->id;
        $result = $this->imageHelper->saveImage($input->avatar);
        $userProfile->avatar_path = $result;
        $this->updateUserProfile($user, $input, $userProfile);
        return $userProfile;
    }

    public function updateUserProfile(User $user, UserOnboardingInput $input, UserProfile $profile): UserProfile {
        $profile->fill($input->all());
        $profile->save();

        return $profile;
    }
}
