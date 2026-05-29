<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->string('profile_photo')->nullable()->after('email');
            $blueprint->string('cover_photo')->nullable()->after('profile_photo');
            $blueprint->string('username')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['profile_photo', 'cover_photo', 'username']);
        });
    }
};
