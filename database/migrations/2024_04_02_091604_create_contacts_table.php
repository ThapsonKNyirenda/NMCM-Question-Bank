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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->morphs('contactable');
            $table->string('name', 200);
            $table->string('title', 200);
            $table->mediumText('photo')->nullable();
            $table->string('email_address', 300)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->mediumText('postal_address')->nullable()->fulltext();
            $table->mediumText('physical_address')->nullable()->fulltext();
            $table->string('fax',10)->nullable();
            $table->string('district', 70)->nullable();
            $table->string('village', 70)->nullable();
            $table->string('traditional_authority', 150)->nullable();
            $table->string('country', 70)->nullable();
            $table->mediumText('website', )->nullable();
            $table->mediumText('facebook_link')->nullable();
            $table->mediumText('twitter_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
