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
        Schema::create('fiscal_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('email', '100');

            $table->string('business_name');
            $table->string('tax_identification_number', 13);
            $table->integer('tax_regime_id');

            $table->string('street');
            $table->integer('external_number');
            $table->string('internal_number')->nullable();
            $table->string('zip_code');
            $table->string('suburb');
            $table->string('city');
            $table->string('state');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_addresses');
    }
};
