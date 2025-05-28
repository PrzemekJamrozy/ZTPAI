<?php

namespace App\Domain\Actions;

use App\Domain\Dto\User\Input\UserOnboardingInput;
use App\Domain\Dto\User\Input\UserProfileUpdateDto;
use App\Helpers\ImageHelper;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Optional;
use Illuminate\Support\Str;

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
        $this->updateUserProfile($input, $userProfile);
        return $userProfile;
    }

    public function updateUserProfile(UserOnboardingInput|UserProfileUpdateDto $input, UserProfile $profile): UserProfile {
        $profile->fill($input->all());
        if ($input->avatar !== null) {
            $result = $this->imageHelper->saveImage($input->avatar);
            $profile->avatar_path = $result;
        }
        if ($input->fbLink) {
            $profile->facebook_link = Str::startsWith($input->fbLink, ["https://", "http://"]) ? $input->fbLink : "https://" . $input->fbLink;
        }
        if ($input->igLink) {
            $profile->instagram_link = Str::startsWith($input->igLink, ["https://", "http://"]) ? $input->igLink : "https://" . $input->igLink;
        }
        $profile->save();

        return $profile;
    }
}
