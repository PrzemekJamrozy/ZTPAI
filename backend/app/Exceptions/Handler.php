<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler {

    public static function handle($request, Throwable $e):JsonResponse {
        if ($e instanceof ValidationException) {
            return ResponseHelper::error($e->errors(), 422);
        }

        if ($e instanceof InvalidCredentialsException) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

        // Because sanctum tries to redirect when user is not logged in we throw 404 not found
        if ($e instanceof RouteNotFoundException) {
            return ResponseHelper::error("Not found", 404);
        }

        if ($e instanceof ModelNotFoundException) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

        if ($e instanceof ImageConversionException) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
        if ($e instanceof UserOnboardingAlreadyFinishedException) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

        if($e instanceof UserNotAuthorized){
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

        //Fallback
        return ResponseHelper::error($e->getMessage());
    }
}
