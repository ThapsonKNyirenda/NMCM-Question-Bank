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
        Schema::create('email_template_folders', function (Blueprint $table){
            $table->id();
            $table->string('name', 100)->unique();
            $table->mediumText('description')->nullable();
            $table->boolean('is_system_template')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignId('email_template_folder_id')->nullable()->constrained()->nullOnDelete();
            $table->string('module', 100);
            $table->string('name', 200)->unique();
            $table->mediumText('email_subject');
            $table->string('reply_to', 150)->nullable();
            $table->text('message');
            $table->boolean('is_system_template')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('email_template_folders');
    }
};
