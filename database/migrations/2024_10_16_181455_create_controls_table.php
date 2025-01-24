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
        Schema::create('controls', function (Blueprint $table) {
            $table->id();
            $table->string('vehiculo')->nullable();
            $table->string('placa')->nullable();
            $table->string('habitacion')->nullable();
            $table->string('entrada')->nullable();
            $table->string('salida')->nullable();
            $table->double('tarifa')->nullable();
            $table->integer('estado')->nullable();
            $table->date('fecha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controls');
    }
};
