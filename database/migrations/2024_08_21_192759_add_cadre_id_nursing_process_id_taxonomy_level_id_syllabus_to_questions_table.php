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
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignId('cadre_id')->constrained()->onDelete('cascade');
            $table->foreignId('nursing_process_id')->constrained()->onDelete('cascade');
            $table->foreignId('taxonomy_level_id')->constrained()->onDelete('cascade');
            $table->string('syllabus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['cadre_id']);
            $table->dropColumn('cadre_id');

            $table->dropForeign(['nursing_process_id']);
            $table->dropColumn('nursing_process_id');

            $table->dropForeign(['taxonomy_level_id']);
            $table->dropColumn('taxonomy_level_id');

            $table->dropColumn('syllabus');
        });
    }
};