<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Database\Eloquent\Builder;

class MatcherQuery extends BaseQuery {
    protected function getModelQuery(): Builder {
        return UserMatch::query();
    }

    public function getMatchesWhichWasAlreadyMadeByUser(User $user): static {
        $this->query->where(function(Builder $builder) use ($user) {
            $builder->where(function(Builder $builder) use ($user) {
                $builder->where('user_first_id', $user->id);
                $builder->where('first_want_match', true);
            });
            $builder->orWhere(function(Builder $builder) use ($user) {
                $builder->where('user_second_id', $user->id);
                $builder->where('second_want_match', true);
            });
        });
        return $this;
    }

    public function getMatchesWhichWasDeclinedByUser(User $user): static {
        $this->query->orWhere(function(Builder $builder) use ($user) {
            $builder->where(function(Builder $builder) use ($user) {
                $builder->where('user_first_id', $user->id);
                $builder->where('first_want_match', false);
            });
            $builder->orWhere(function(Builder $builder) use ($user) {
                $builder->where('user_second_id', $user->id);
                $builder->where('second_want_match', false);
            });
        });
        return $this;
    }

    public function whereMatchesApproved(User $user): static {
        $this->query->where(function(Builder $builder) use ($user) {
            $builder->where('user_first_id', $user->id);
            $builder->orWhere('first_want_match', true);
        });
        $this->query->where('show_match', true);
        return $this;
    }

    public function whereMatchExistsForUser(User $user, int $secondUserId): static {
        $this->query->where(function(Builder $builder) use ($user,$secondUserId) {
           $builder->where(function(Builder $builder) use ($user,$secondUserId) {
               $builder->where('user_first_id', $user->id);
               $builder->where('user_second_id', $secondUserId);
           });
            $builder->orWhere(function(Builder $builder) use ($user,$secondUserId) {
                $builder->where('user_first_id',  $secondUserId);
                $builder->where('user_second_id', $user->id);
            });
        });

        return $this;
    }
}
