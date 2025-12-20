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
        Schema::create('order_service_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('order_service_id')
                ->constrained('order_services');

            $table->foreignId('service_mode_price_id')
                ->constrained('service_price_tiers');

            $table->foreignId('order_substatus_id')
                ->constrained('order_substatuses');

            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service_items');
    }
};
