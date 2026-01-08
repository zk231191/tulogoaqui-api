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
        Schema::create('order_service_substatuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');

            $table->foreignId('order_service_status_id')
                ->constrained('order_service_statuses');

            $table->unsignedSmallInteger('sequence');

            $table->boolean('is_final')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['order_service_status_id', 'sequence']);
            $table->unique(['order_service_status_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service_substatuses');
    }
};
