<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DebugController extends Controller
{
    public function debug() {
        Role::create(['name' => Roles::USER->value]);
        Role::create(['name' => Roles::ADMIN->value]);

        return "Roles added";
    }
}
