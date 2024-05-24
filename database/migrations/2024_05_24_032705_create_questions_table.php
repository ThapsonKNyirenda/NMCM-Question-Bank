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
            $table->uuid()->index();
            $table->string('title',100);
            $table->string('cadre',100);
            $table->string('nursing_process',100);
            $table->string('Disease_area',100);
            $table->string('syllabus',100);
            $table->string('question_description',250);
            $table->string('choice_a',250);
            $table->string('choice_b',250);
            $table->string('choice_c',250);
            $table->string('choice_d',250);
            $table->string('correct_answer',250);
            $table->string('status',100);
            $table->timestamps();
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