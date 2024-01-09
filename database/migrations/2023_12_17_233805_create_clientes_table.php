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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('country')->default('colombia');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone');
            $table->integer('quantity_numbers')->nullable();
            $table->json('numbersR')->nullable();
            $table->string('email');
            $table->string('reference')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
