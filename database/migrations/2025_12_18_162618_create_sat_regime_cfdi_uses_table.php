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
        Schema::create('sat_regime_cfdi_uses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('regime_code', 5);
            $table->string('cfdi_use_code', 5);

            $table->timestamps();

            $table->foreign('regime_code')
                ->references('code')
                ->on('sat_regimes')
                ->cascadeOnDelete();

            $table->foreign('cfdi_use_code')
                ->references('code')
                ->on('sat_cfdi_uses')
                ->cascadeOnDelete();

            $table->unique(['regime_code', 'cfdi_use_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sat_regime_cfdi_uses');
    }
};
