<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property int $user_first_id
 * @property int $user_second_id
 * @property bool|null $first_want_match
 * @property bool|null $second_want_match
 * @property bool|null $show_match
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $firstUser
 * @property-read User $secondUser
 */
class UserMatch extends Model
{
    protected $fillable = [
        'user_first_id',
        'user_second_id',
    ];

    public function firstUser():BelongsTo{
        return $this->belongsTo(User::class, 'user_first_id');
    }

    public function secondUser():BelongsTo{
        return $this->belongsTo(User::class, 'user_second_id');
    }

}
