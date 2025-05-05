<?php

namespace App\Domain\Dto\User\Input;

use App\Enums\PreferredGender;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class UserOnboardingInput extends Data {

    #[MapOutputName('user_bio')]
    public string $bio;

    #[MapOutputName('facebook_link')]
    public string $fbLink;
    #[MapOutputName('instagram_link')]
    public string $igLink;
    #[MapOutputName('preferred_gender')]
    public PreferredGender $preferredGender;
    public string $avatar;
}
