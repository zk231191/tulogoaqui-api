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
        Schema::create('order_sub_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->integer(''); // 8679.12 -> 169.24 + 1.70 => 170.94 => 198.29  8909.14
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_sub_statuses');
    }
};
