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
        // Starting balance every account is granted; keep in sync with the
        // column defaults below.
        $base = 50;

        Schema::table('users', function (Blueprint $table) use ($base) {
            if (! Schema::hasColumn('users', 'points')) {
                // Current spendable balance.
                $table->unsignedInteger('points')->default($base)->after('best_streak');
            }

            if (! Schema::hasColumn('users', 'highest_points')) {
                // High-water mark: the largest balance this account has ever held.
                $table->unsignedInteger('highest_points')->default($base)->after('points');
            }
        });

        // Seed existing accounts with the starting balance plus rewards already
        // earned. Nothing has been spent yet, so the peak equals the balance.
        $totals = DB::table('task_collaborations')
            ->where('status', 'completed')
            ->selectRaw('user_id, SUM(reward_earned) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        foreach ($totals as $userId => $total) {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'points' => $base + (int) $total,
                    'highest_points' => $base + (int) $total,
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
