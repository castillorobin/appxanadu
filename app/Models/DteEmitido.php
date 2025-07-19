<?php

// app/Models/DteEmitido.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DteEmitido extends Model
{
    protected $fillable = [
        'codigo_generacion', 'tipo_documento', 'fecha_emision', 'estado',
        'json_original', 'respuesta_dgii'
    ];

    protected $casts = [
        'json_original' => 'array',
        'respuesta_dgii' => 'array',
        'fecha_emision' => 'date'
    ];
}