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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->text('description')->nullable(); 
            $table->string('accent'); 
            $table->string('icon'); 
            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');
            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'on_hold',
                'cancelled'
            ])->default('pending');
            $table->date('deadline')->nullable(); 
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate(); 
            $table->boolean('is_completed')->default(false); 
            $table->timestamps();
        });

        Schema::create('task_user', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete()->cascadeOnUpdate(); 
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate(); 
            $table->primary(['task_id', 'user_id']); 
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_user'); 
        Schema::dropIfExists('tasks'); 
    }
};
