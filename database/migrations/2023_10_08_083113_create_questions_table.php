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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('question_topic');
            $table->string('question_content');
            $table->string('question_answer')->nullable();
            $table->timestamp('question_asked_time')->nullable();
            $table->timestamp('question_answered_time')->nullable();
            $table->timestamp('time_taken')->nullable();

            $table->foreignId("teacher_id")->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId("student_id")->constrained()->onDelete('cascade');
            $table->foreignId("session_id")->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
