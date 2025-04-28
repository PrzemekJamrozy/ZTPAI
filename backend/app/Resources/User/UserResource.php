<?php

namespace App\Resources\User;

use App\Enums\GenderEnum;
use App\Enums\UserStatus;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     description="User",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Jan Kowalski"),
 *     @OA\Property(property="surname", type="string", example="jan@example.com"),
 *     @OA\Property(property="email", type="string", example="jan@example.com"),
 *     @OA\Property(property="status", type="string", example="ACTIVE", description="Either ACTIVE or DURING_REGISTER"),
 *     @OA\Property(property="gender", type="string", example="MALE", description="Either MALE or FEMALE")
 * )
 */
class UserResource extends Data {

    public int $id;
    public string $name;
    public string $surname;
    public string $email;
    public UserStatus $status;
    public GenderEnum $gender;

}
