<?php

namespace Database\Factories;

use App\Enums\PreferredGender;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\ImageHelper;

class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    public function definition()
    {
        return [
            'user_id'         => User::factory(),
            'preferred_gender'=> $this->faker->randomElement(PreferredGender::cases()),
            'user_bio'        => $this->faker->sentence(10),
            'facebook_link'   => $this->faker->url,
            'instagram_link'  => $this->faker->url,
            'avatar_path'     => 'https://picsum.photos/1000',
        ];
    }
}
