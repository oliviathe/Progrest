<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'last_login_date')) {
                $table->date('last_login_date')->nullable()->after('auth_provider');
            }

            if (! Schema::hasColumn('users', 'current_streak')) {
                $table->unsignedInteger('current_streak')->default(0)->after('last_login_date');
            }

            if (! Schema::hasColumn('users', 'best_streak')) {
                $table->unsignedInteger('best_streak')->default(0)->after('current_streak');
            }
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('is_completed');
            }
        });

        // Backfill completion timestamps for tasks that were already finished
        // before this column existed. updated_at is the closest available signal.
        DB::table('tasks')
            ->where('is_completed', true)
            ->whereNull('completed_at')
            ->update(['completed_at' => DB::raw('updated_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_login_date', 'current_streak', 'best_streak']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });
    }
};
