<?php

namespace App\Domain\Services;

use App\Models\User;
use App\Repositories\UserQuery;
use Illuminate\Support\Collection;

class AdminUserService {


    public function getUsers():Collection {
        $users = UserQuery::create()->get();
        return $users;
    }


    public function getUser(int $userId):User {
        $user = UserQuery::create()->find($userId);
        return $user;
    }
}
