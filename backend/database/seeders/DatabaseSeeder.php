<?php

namespace Database\Seeders;

use App\Domain\Actions\UserActions;
use App\Enums\Roles;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $admin = User::factory()->create([
            'name'     => 'Admin',
            'surname'  => 'Super',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'gender'   => 'MALE',
            'status'   => 'ACTIVE',
        ]);
        $admin->assignRole(Roles::ADMIN);
        UserProfile::factory()->for($admin)->create();
        $users = User::factory(30)->create();
        foreach ($users as $user) {
            UserProfile::factory()->for($user)->create();
            $user->assignRole(Roles::USER);
        }


    }
}
