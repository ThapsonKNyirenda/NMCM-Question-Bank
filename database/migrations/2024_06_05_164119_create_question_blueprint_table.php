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
        Schema::create('question_blueprint', function (Blueprint $table) {
            $table->id();
            $table->string('cadre',200);
            $table->string('nursing_process',200);
            $table->string('disease_area',200);
            $table->string('taxonomy_level',200);
            $table->string('syllabus',200);
            $table->integer('number_of_questions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_blueprint');
    }
};