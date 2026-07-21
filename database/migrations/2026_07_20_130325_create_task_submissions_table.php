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
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('task_id')
                ->constrained()
                ->cascadeOnDelete();

            // User who submitted on behalf of the team
            $table->foreignId('submitted_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Reviewer (Project Leader)
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('proof_image')->nullable();
            $table->string('proof_link')->nullable();

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            $table->text('review_comment')->nullable();

            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};