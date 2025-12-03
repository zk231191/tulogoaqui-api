<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fiscal_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('business_name')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Un domicilio activo por cliente
            $table->unique(['customer_id', 'deleted_at']);
            // RFC único entre registros no eliminados
            $table->unique(['rfc', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiscal_addresses');
    }
};