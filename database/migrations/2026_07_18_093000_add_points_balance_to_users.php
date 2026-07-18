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
            if (! Schema::hasColumn('users', 'points')) {
                // Current spendable balance.
                $table->unsignedInteger('points')->default(0)->after('best_streak');
            }

            if (! Schema::hasColumn('users', 'highest_points')) {
                // High-water mark: the largest balance this account has ever held.
                $table->unsignedInteger('highest_points')->default(0)->after('points');
            }
        });

        // Seed the balance from rewards already earned, so existing accounts
        // don't reset to zero. Nothing has been spent yet, so the peak equals
        // the total at this point in time.
        $totals = DB::table('task_collaborations')
            ->where('status', 'completed')
            ->selectRaw('user_id, SUM(reward_earned) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        foreach ($totals as $userId => $total) {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'points' => (int) $total,
                    'highest_points' => (int) $total,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['points', 'highest_points']);
        });
    }
};
