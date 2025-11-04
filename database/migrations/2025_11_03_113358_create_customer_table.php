<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('customers',function (blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fiscal_addresses', function (blueprint $table){
            $table->id();
            $table->foreignId('customer_id')->unique()->constrained('customers');
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('rfc')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void{
        schema::dropIfExists('fiscal_addresses');
        schema::dropIfExists('customers');
    }
}

?>