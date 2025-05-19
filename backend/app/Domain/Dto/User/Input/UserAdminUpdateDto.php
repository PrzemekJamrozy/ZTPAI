<?php

namespace App\Domain\Dto\User\Input;

use App\Enums\GenderEnum;
use App\Enums\Roles;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * @OA\Schema(
 *     schema="UserAdminUpdateDto",
 *     description="User update",
 *     @OA\Property(property="name", type="string", example="Jan"),
 *     @OA\Property(property="surname", type="string", example="Kowalski"),
 *     @OA\Property(property="email", type="string", example="jan@example.com"),
 *     @OA\Property(property="password", type="string", example="password"),
 *     @OA\Property(property="gender", type="string", example="MALE", description="Either MALE or FEMALE"),
 * )
 */
class UserAdminUpdateDto extends Data {

    public string|Optional $name;
    public string|Optional $surname;

    #[Email]
    public string|Optional $email;
    public string|Optional|null $password;
    public GenderEnum|Optional $gender;
    public UserProfileUpdateDto|Optional $profile;
    public Roles|Optional $role;
}
