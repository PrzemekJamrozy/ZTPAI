<?php

namespace App\Domain\Actions;

use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Support\Collection;

class MatcherActions {

    /**
     * Filter list of users to display on swiper. If given user made a request to match we filter it
     *
     * @param Collection $users
     * @param Collection $userMatches
     * @param User $user
     * @return Collection
     */
    public function filterUsersToShowOnMatcher(Collection $users, Collection $userMatches, User $user) {
        $userIdsToFilter = $userMatches->map(function (UserMatch $match) {
            return collect([$match->user_first_id, $match->user_second_id]);
        })
            ->map(function (Collection $pairs) use ($user) {
                return $pairs->filter(fn(int $id) => $id !== $user->id)->flatten();
            })->flatten();

        $usersThatCanBeDisplayedInMatcher = $users->filter(fn(User $user) => !$userIdsToFilter->contains($user->id));

        return $usersThatCanBeDisplayedInMatcher;
    }

    public function createMatch(User $firstUser, int $secondUser): UserMatch {
        $match = new UserMatch();
        $match->user_first_id = $firstUser->id;
        $match->user_second_id = $secondUser;
        $match->first_want_match = true;
        $match->save();
        return $match;
    }

    public function resolveMatchAccept(UserMatch $userMatch, User $user): UserMatch {
        if ($userMatch->user_first_id === $user->id) {
            $userMatch->first_want_match = true;
        } else {
            $userMatch->second_want_match = true;
        }
        $userMatch->save();
        return $userMatch;
    }
}
