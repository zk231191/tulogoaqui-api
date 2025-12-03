<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('paternal_last_name')->nullable();
            $table->string('maternal_last_name')->nullable();
            $table->string('phone', 20);
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('facture_required')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Permite reutilizar email si el registro anterior está soft-deleted
            $table->unique(['email', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};