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
        Schema::create('comments', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');  // each comment belongs to a task
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // author of the comment
            $table->text('body'); // comment content
            $table->timestamps(); // created_at will act as timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
