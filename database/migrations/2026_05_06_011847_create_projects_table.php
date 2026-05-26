<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('leader_id')->constrained('users')->cascadeOnDelete(); 
            $table->string('title'); 
            $table->text('description')->nullable(); 

            $table->string('status')->default('active'); 

            $table->unsignedTinyInteger('progress')->default(0); 
            $table->string('accent'); 
            $table->timestamps(); 

            $table->string('icon')->default('folder-git-2'); 
            $table->date('deadline')->nullable(); 

            $table->index('leader_id'); 
            $table->index('status'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
