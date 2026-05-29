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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('active_path_id')->nullable()->after('password');
            $table->integer('frontend_current_step')->default(0)->after('active_path_id');
            $table->integer('backend_current_step')->default(0)->after('frontend_current_step');
            $table->integer('uiux_current_step')->default(0)->after('backend_current_step');
            $table->integer('fullstack_current_step')->default(0)->after('uiux_current_step');
            $table->integer('pm_current_step')->default(0)->after('fullstack_current_step');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'active_path_id',
                'frontend_current_step',
                'backend_current_step',
                'uiux_current_step',
                'fullstack_current_step',
                'pm_current_step'
            ]);
        });
    }
};
