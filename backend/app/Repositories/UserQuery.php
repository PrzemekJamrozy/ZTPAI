<?php

namespace App\Repositories;

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

}
