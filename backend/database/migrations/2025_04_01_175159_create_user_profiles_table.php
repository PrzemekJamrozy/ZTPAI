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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')
                ->constrained('users');
            $table->string('preferred_gender');
            $table->text('user_bio');
            $table->string('facebook_link');
            $table->string('instagram_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('user_profiles');
    }
};
