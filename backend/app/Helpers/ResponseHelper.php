<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper {


    public static function success($data, $status = 200):JsonResponse {
        return new JsonResponse(
            [
                'success' => true,
                'status' => $status,
                'data' => $data
            ]
        );
    }

    public static function error($data, $status = 400):JsonResponse {
        return new JsonResponse(
            [
                'success' => false,
                'status' => $status,
                'data' => $data
            ]
        );
    }
}
