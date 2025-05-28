<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper;
use Illuminate\Auth\AuthenticationException;
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

        if($e instanceof AuthenticationException){
            return ResponseHelper::error($e->getMessage(), 401);
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
