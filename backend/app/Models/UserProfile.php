<?php

namespace App\Models;

use App\Enums\PreferredGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property int $user_id
 * @property PreferredGender $preferred_gender
 * @property string user_bio
 * @property string $facebook_link
 * @property string $instagram_link
 * @property string $avatar_path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 */
class UserProfile extends Model {
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;
    protected $fillable = [
        'user_bio',
        'facebook_link',
        'instagram_link',
        'preferred_gender',
    ];

    protected $casts = [
        'preferred_gender' => PreferredGender::class,
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

}
