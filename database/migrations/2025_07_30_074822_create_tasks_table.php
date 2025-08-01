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
            $table->softDeletes();
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // Each task belongs to one project
            $table->string('task_name');
            $table->text('task_description')->nullable();
            $table->enum('task_status', ['todo', 'in_progress', 'completed'])->default('todo');
            $table->enum('task_priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('task_due_date')->nullable();
            $table->json('task_labels')->nullable(); // for tags/labels
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
