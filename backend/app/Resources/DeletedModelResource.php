<?php

namespace App\Resources;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     schema="DeletedModelResource",
 *     description="Delete user",
 *     @OA\Property(property="id", type="int", example="1")
 * )
 */
class DeletedModelResource extends Data {


    public function __construct(
        public int $id,
    ) {
    }
}
