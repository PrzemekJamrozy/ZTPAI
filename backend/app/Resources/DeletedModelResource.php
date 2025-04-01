<?php

namespace App\Resources;

use Spatie\LaravelData\Data;

class DeletedModelResource extends Data {


    public function __construct(
        public int $id,
    ) {
    }
}
