<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documento_d_t_e_s', function (Blueprint $table) {
            // Modo contingencia
            $table->boolean('es_contingencia')->default(false)->after('tipo_dte');
            $table->string('motivo_contingencia')->nullable()->after('es_contingencia');
            $table->dateTime('fecha_contingencia')->nullable()->after('motivo_contingencia');

            // Regularización posterior
            $table->boolean('regularizado')->default(false)->after('fecha_contingencia');
            $table->dateTime('fecha_regularizacion')->nullable()->after('regularizado');
        });
    }

    public function down()
    {
        Schema::table('documento_d_t_e_s', function (Blueprint $table) {
            $table->dropColumn([
                'es_contingencia',
                'motivo_contingencia',
                'fecha_contingencia',
                'regularizado',
                'fecha_regularizacion',
            ]);
        });
    }
};