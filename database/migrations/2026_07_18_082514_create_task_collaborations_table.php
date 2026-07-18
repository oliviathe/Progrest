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
        Schema::create('task_collaborations', function (Blueprint $table) {
            $table->id();

            // Task being collaborated on
            $table->foreignId('task_id')
                ->constrained()
                ->cascadeOnDelete();

            // Collaborator
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Collaboration status
            $table->enum('status', [
                'declined',
                'in_progress',
                'completed'
            ])->default('pending');

            // Reward actually earned
            $table->unsignedInteger('reward_earned')->default(0);

            // Timestamps
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Prevent duplicate collaborator entries
            $table->unique(['task_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_collaborations');
    }
};