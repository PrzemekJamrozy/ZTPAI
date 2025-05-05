<?php

namespace App\Repositories;

use App\Enums\PreferredGender;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @phpstan-extends BaseQuery<User>
 */
class UserQuery extends BaseQuery {
    protected function getModelQuery(): Builder {
        return User::query();
    }

    public function whereEmail(string $email): static {
        $this->query->where('email', $email);
        return $this;
    }

    public function whereStatus(UserStatus $status): static {
        $this->query->where('status', $status);
        return $this;
    }

    public function whereIdNot(int $id): static {
        $this->query->whereNot('id', $id);
        return $this;
    }

    public function wherePreferredGender(PreferredGender $preferredGender): static {
        if($preferredGender === PreferredGender::BOTH) {
            return $this;
        }
        $this->query->where('gender', $preferredGender->toGenderEnum());
        return $this;
    }
}
