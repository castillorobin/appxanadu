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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('cliente')->nullable();
            $table->date('fecha')->nullable();
            $table->string('DUI')->nullable();
            $table->string('codigo')->nullable();
            $table->string('direccion')->nullable();
            $table->double('IVA')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
