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
        //
        Schema::table('question_blueprints', function (Blueprint $table) {
            $table->string('question_paper_code')->nullable()->after('number_of_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('question_blueprints', function (Blueprint $table) {
            $table->dropColumn('question_paper_code');
        });
    }
};