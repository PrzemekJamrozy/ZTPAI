<?php

namespace App\Domain\Services;

use App\Domain\Actions\MatcherActions;
use App\Domain\Dto\Matcher\MatchInput;
use App\Models\User;
use App\Models\UserMatch;
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
            ->loadRelation("profile")
            ->loadRelation("roles")
            ->whereIdNot($currentUser->id)
            ->wherePreferredGender($currentUser->profile->preferred_gender)
            ->get();

        $filterCollection = MatcherQuery::create()
            ->getMatchesWhichWasAlreadyMadeByUser($currentUser)
            ->getMatchesWhichWasDeclinedByUser($currentUser)
            ->get();

        $usersToShowInMatcher = $this->matcherActions->filterUsersToShowOnMatcher($users, $filterCollection, $currentUser);

        return $usersToShowInMatcher->flatten();
    }

    /**
     * @return Collection<int,User>
     */
    public function getMatches(User $currentUser): Collection {
        $userMatches = MatcherQuery::create()
            ->loadRelation("firstUser")
            ->loadRelation("secondUser")
            ->whereMatchesApproved($currentUser)
            ->get();

        $userList = $userMatches->map(function (UserMatch $match) use ($currentUser) {
            if($currentUser->id === $match->user_first_id){
                return $match->secondUser;
            }else{
                return $match->firstUser;
            }
        });
        return $userList;
    }

    public function acceptMatch(User $currentUser, MatchInput $input) {
        //Check if match already exists
        $match = MatcherQuery::create()
            ->whereMatchExistsForUser($currentUser, $input->idOfUserUserWantToMatch)
            ->first();

        if ($match === null) {
            //If no create new intent
            $match = $this->matcherActions->createMatch($currentUser, $input->idOfUserUserWantToMatch,true);
        } else {
            //If yes set value to want match to true for given user
            $this->matcherActions->resolveMatch($match, $currentUser,true);
        }

        return $match;
    }

    public function rejectMatch(User $currentUser, MatchInput $input) {
        //Check if match already exists
        $match = MatcherQuery::create()
            ->whereMatchExistsForUser($currentUser, $input->idOfUserUserWantToMatch)
            ->first();

        if ($match === null) {
            //If no create new intent
            $match = $this->matcherActions->createMatch($currentUser, $input->idOfUserUserWantToMatch,false);
        } else {
            //If yes set value to want match to false for given user
            $this->matcherActions->resolveMatch($match, $currentUser,false);
        }

        return $match;
    }

}
