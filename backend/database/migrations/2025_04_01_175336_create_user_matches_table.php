<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('user_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_first_id')
                ->constrained('users');
            $table->foreignIdFor(User::class, 'user_second_id')
                ->constrained('users');
            $table->boolean('first_want_match')
                ->nullable();
            $table->boolean('second_want_match')
                ->nullable();

            $table->timestamps();
        });

        Schema::table('user_matches', function (Blueprint $table) {
            $table->boolean('show_match')
                ->storedAs('first_want_match AND second_want_match')
                ->after('second_want_match')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('user_matches');
    }
};
