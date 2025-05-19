<?php

namespace App\Domain\Dto\User\Input;

use App\Enums\PreferredGender;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
/**
 * @OA\Schema(
 *     schema="UserOnboardingInput",
 *     description="Additional data of user",
 *     @OA\Property(property="bio", type="string", example="Example bio"),
 *     @OA\Property(property="fbLink", type="string", example="https://facebook.com"),
 *     @OA\Property(property="igLink", type="string", example="https://instagram.com"),
 *     @OA\Property(property="preferredGender", type="string", example="MALE", description="Either MALE, FEMALE or BOTH"),
 *     @OA\Property(property="avatar", type="string", description="Base64 encoded image"),
 * )
 */
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
