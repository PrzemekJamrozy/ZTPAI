<?php

namespace App\Domain\Services;

use App\Domain\Actions\MatcherActions;
use App\Domain\Dto\Matcher\AcceptMatchInput;
use App\Models\User;
use App\Repositories\MatcherQuery;
use App\Repositories\UserQuery;
use Illuminate\Support\Collection;

class MatcherService {


    public function __construct(
        protected MatcherActions $matcherActions,
    ) {
    }

    public function getPotentialMatches(User $currentUser): Collection {
        $users = UserQuery::create()
            ->whereIdNot($currentUser->id)
            ->wherePreferredGender($currentUser->profile->preferred_gender)
            ->get();

        $filterCollection = MatcherQuery::create()
            ->getMatchesWhichWasAlreadyMadeByUser($currentUser)
            ->getMatchesWhichWasDeclinedByUser($currentUser)
            ->get();

        $usersToShowInMatcher = $this->matcherActions->filterUsersToShowOnMatcher($users, $filterCollection, $currentUser);

        return $usersToShowInMatcher;
    }

    public function getMatches(User $currentUser): Collection {
        $userMatches = MatcherQuery::create()
            ->whereMatchesApproved($currentUser)
            ->get();


        return $userMatches;
    }

    public function acceptMatch(User $currentUser, AcceptMatchInput $input) {
        //Check if match already exists
        $match = MatcherQuery::create()
            ->whereMatchExistsForUser($currentUser, $input->idOfUserUserWantToMatch)
            ->first();

        if ($match === null) {
            //If no create new intent
            $match = $this->matcherActions->createMatch($currentUser, $input->idOfUserUserWantToMatch);
        } else {
            //If yes set value to want match to true for given user
            $this->matcherActions->resolveMatchAccept($match, $currentUser);
        }

        return $match;
    }
}
