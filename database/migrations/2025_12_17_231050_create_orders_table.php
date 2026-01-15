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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('public_token')->unique();

            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('order_status_id');

            $table->foreignId('fiscal_address_id')
                ->nullable()
                ->constrained('fiscal_addresses')
                ->nullOnDelete();

            $table->boolean('require_invoice')
                ->default(false);
            $table->string('cfdi_use_code', 3)
                ->nullable();

            $table->foreignId('branch_id')
                ->default(1);

            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)
                ->default(0);
            $table->decimal('tax', 12, 2)
                ->default(0);
            $table->decimal('total', 12, 2);

            $table->decimal('paid_amount', 12, 2)
                ->default(0);
            $table->decimal('pending_amount', 12, 2);

            $table->text('comments')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
