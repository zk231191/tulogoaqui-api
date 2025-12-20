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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('payment_method_id')
                ->constrained('payment_methods');

            $table->decimal('amount', 15, 2);

            $table->boolean('apply_tax')->default(false);
            $table->decimal('tax_amount', 15, 2)->default(0);

            $table->string('reference')->nullable();

            $table->enum('status', ['paid', 'refunded', 'cancelled'])->default('paid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
