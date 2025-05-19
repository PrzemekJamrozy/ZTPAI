<?php

namespace App\Http\Controllers;

use App\Domain\Dto\Matcher\MatchInput;
use App\Domain\Services\MatcherService;
use App\Helpers\ResponseHelper;
use App\Repositories\UserQuery;
use App\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatcherController extends Controller {

    public function __construct(
        protected MatcherService $matcherService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/match/get-potential-matches",
     *     summary="Get potential matches for logged user",
     *     tags={"Match"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Return list of user which is potential match",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     * )
     */
    public function getPotentialMatches(Request $request) {
        $result = $this->matcherService->getPotentialMatches(Auth::user());

        return ResponseHelper::success(UserResource::collect($result));
    }

    /**
     * @OA\Get(
     *     path="/api/match/get-matches",
     *     summary="Get matches for logged user",
     *     tags={"Match"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Return list of user which is match",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     * )
     */
    public function getMatches(Request $request) {
        $result = $this->matcherService->getMatches(Auth::user());

        return ResponseHelper::success(UserResource::collect($result));
    }

    /**
     * @OA\Post (
     *     path="/api/match/accept-match",
     *     summary="Create or accept match of a given user for logged user",
     *     tags={"Match"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"idOfUserUserWantToMatch"},
     *              @OA\Property(property="idOfUserUserWantToMatch", type="int", example="1", description="Id of user which logged user want to accept"),
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Return message with success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function acceptMatch(Request $request) {
        $this->matcherService->acceptMatch(
            Auth::user(),
            MatchInput::from($request->all()));

        return ResponseHelper::success("Success");
    }

    /**
     * @OA\Post (
     *     path="/api/match/reject-match",
     *     summary="Create or reject match of a given user for logged user",
     *     tags={"Match"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              required={"idOfUserUserWantToMatch"},
     *              @OA\Property(property="idOfUserUserWantToMatch", type="int", example="1", description="Id of user which logged user want to reject"),
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Return message with success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(
     *                 property="data",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=422, description="Invalid body")
     * )
     */
    public function rejectMatch(Request $request) {
        $this->matcherService->rejectMatch(
            Auth::user(),
            MatchInput::from($request->all()));

        return ResponseHelper::success("Success");
    }
}
