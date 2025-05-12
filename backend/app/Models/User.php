<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\GenderEnum;
use App\Enums\UserStatus;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property UserStatus $status
 * @property GenderEnum $gender
 * @property-read UserProfile $profile
 * @property-read Collection<int,UserMatch> $matchesAsFirst
 * @property-read Collection<int,UserMatch> $matchesAsSecond
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'gender',
        'surname'
    ];

    protected $casts = [
        'status' => UserStatus::class,
        'gender' => GenderEnum::class,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile():HasOne {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function matchesAsFirst():HasMany {
        return $this->hasMany(UserMatch::class, 'user_first_id');
    }

    public function matchesAsSecond():HasMany {
        return $this->hasMany(UserMatch::class, 'user_second_id');
    }

    public function matches():Collection {
        return $this->matchesAsFirst->merge($this->matchesAsSecond);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
