<?php

// database/migrations/xxxx_xx_xx_create_dtes_emitidos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dte_emitidos', function (Blueprint $table) {
             $table->id();
            $table->string('codigo_generacion')->unique();
            $table->string('numero_control');
            $table->string('factura');
            $table->string('tipo_documento');
            $table->date('fecha_emision');
            $table->string('estado')->default('PENDIENTE');
            $table->json('json_original');
            $table->json('respuesta_dgii')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dtes_emitidos');
    }
};