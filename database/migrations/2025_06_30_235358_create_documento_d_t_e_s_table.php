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
        Schema::create('documento_d_t_e_s', function (Blueprint $table) {
            $table->id();
            $table->string('sello_recibido')->nullable();
    $table->uuid('codigo_generacion')->nullable();
    $table->string('numero_control')->nullable();
    $table->string('factura')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_d_t_e_s');
    }
};
