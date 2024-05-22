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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('name', 200)->unique();
            $table->foreignId('contact_person_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->string('tax_id')->nullable();
            $table->mediumText('photo')->nullable();
            $table->string('customer_type', 30);
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('billing_contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('technical_contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('administrative_contact_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->mediumText('description')->nullable();
            $table->string('customer_number', 10)->nullable()->unique();
            $table->string('support_pin', 10)->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
