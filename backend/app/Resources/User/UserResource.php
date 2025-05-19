<?php

namespace App\Resources\User;

use App\Enums\GenderEnum;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Collection;
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
 *     @OA\Property(property="gender", type="string", example="MALE", description="Either MALE or FEMALE"),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         example={"USER"},
 *         description="Array of roles of user in system",
 *         @OA\Items(type="string", enum={"USER","ADMIN"})
 *     )
 * )
 */

class UserResource extends Data {

    public function __construct(
        public int                      $id,
        public string                   $name,
        public string                   $surname,
        public string                   $email,
        public UserStatus               $status,
        public GenderEnum               $gender,
        public array                    $roles,
        public UserProfileResource|null $profile) {
    }

    public static function fromModel(User $user): self {
        return new self(
            $user->id,
            $user->name,
            $user->surname,
            $user->email,
            $user->status,
            $user->gender,
            $user->getRoleNames()->toArray(),
            $user->profile !== null ? UserProfileResource::from($user->profile) : null
        );
    }
}
