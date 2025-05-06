<?php

namespace App\Domain\Dto\User\Input;

use App\Enums\PreferredGender;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class UserProfileUpdateDto extends Data {

    #[MapOutputName('user_bio')]
    public string|Optional $bio;
    #[MapOutputName('facebook_link')]
    public string|Optional $fbLink;
    #[MapOutputName('instagram_link')]
    public string|Optional $igLink;
    #[MapOutputName('preferred_gender')]
    public PreferredGender|Optional $preferredGender;
    public string|Optional|null $avatar;
}
