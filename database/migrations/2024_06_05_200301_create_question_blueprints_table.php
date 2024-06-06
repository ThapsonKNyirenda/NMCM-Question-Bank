<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionBlueprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_blueprints', function (Blueprint $table) {
            $table->id();
            $table->string('cadre');
            $table->string('nursing_process');
            $table->string('disease_area');
            $table->string('taxonomy');
            $table->string('syllabus');
            $table->integer('number_of_questions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_blueprints');
    }
}
