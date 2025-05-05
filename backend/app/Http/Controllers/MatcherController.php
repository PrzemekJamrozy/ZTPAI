<?php

namespace App\Http\Controllers;

use App\Domain\Dto\Matcher\AcceptMatchInput;
use App\Domain\Services\MatcherService;
use App\Helpers\ResponseHelper;
use App\Repositories\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatcherController extends Controller {

    public function __construct(
        protected MatcherService $matcherService
    ) {
    }

    public function getPotentialMatches(Request $request) {
        $this->matcherService->getPotentialMatches(Auth::user());

        return ResponseHelper::success("Success");
    }

    public function getMatches(Request $request) {
        $result = $this->matcherService->getMatches(Auth::user());

        return ResponseHelper::success("Success");
    }

    public function acceptMatch(Request $request) {
        $this->matcherService->acceptMatch(
            Auth::user(),
            AcceptMatchInput::from($request->all()));

        return ResponseHelper::success("Success");
    }
}
