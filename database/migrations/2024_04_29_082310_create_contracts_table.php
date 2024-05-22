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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained(
                table: 'customers', indexName: 'customer_id'
            );

            $table->foreignId('service_id')->constrained(
                table: 'services', indexName: 'service_id'
            );
            // $table->string('service_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('billing_cycle');  // should be changed to enum
            $table->string('monthly_rate');
            $table->string('status'); // should be changed to enum
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
