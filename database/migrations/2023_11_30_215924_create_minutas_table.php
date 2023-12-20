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
        Schema::create('minutas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('entrada_verified_at')->nullable();
            $table->timestamp('salida_verified_at')->nullable();

            // Definir la llave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps(); // Agregar timestamps created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutas');
    }
};
