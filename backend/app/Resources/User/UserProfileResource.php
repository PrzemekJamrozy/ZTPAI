<?php

namespace App\Resources\User;

use App\Enums\GenderEnum;
use App\Enums\PreferredGender;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class UserProfileResource extends Data {
    #[MapInputName('user_bio')]
    public string $bio;
    #[MapInputName('facebook_link')]
    public string $fbLink;
    #[MapInputName('instagram_link')]
    public string $igLink;
    #[MapInputName('preferred_gender')]
    public PreferredGender $preferredGender;
    #[MapInputName('avatar_path')]
    public string $avatar;
}
