<?php

namespace App\Enums;

enum PreferredGender:string {

    case MALE = 'MALE';
    case FEMALE = 'FEMALE';
    case BOTH = 'BOTH';

    public function toGenderEnum(): GenderEnum{
        return GenderEnum::from($this->value);
    }
}
