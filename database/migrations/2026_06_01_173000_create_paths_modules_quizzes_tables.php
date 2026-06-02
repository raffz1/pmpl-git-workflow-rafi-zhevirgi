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
        // Add role column to users table if not exists
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('email');
            });
        }

        // Create paths table
        Schema::create('paths', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon');
            $table->string('image');
            $table->text('description');
            $table->string('theme');
            $table->string('salary_range')->nullable();
            $table->json('skills')->nullable();
            $table->json('suitability')->nullable();
            $table->text('career_description')->nullable();
            $table->timestamps();
        });

        // Create modules table
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('path_id')->constrained('paths')->onDelete('cascade');
            $table->integer('step_number'); // 0-indexed or 1-indexed step in the path
            $table->string('title');
            $table->text('desc');
            $table->string('side'); // 'left' or 'right' for roadmap rendering
            $table->string('icon'); // '01', '02', etc.
            $table->string('content_title');
            $table->longText('content_body');
            $table->timestamps();
        });

        // Create quizzes table
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->text('question');
            $table->json('options'); // Store options as JSON array
            $table->integer('correct'); // Index of the correct answer (0, 1, 2...)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('paths');
        
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
