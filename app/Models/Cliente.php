<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'Nombre',
        'Telefono',
        'Direccion',
        'Correo',  
        'DUI',
        'placa',
        'nrc',
        'giro',
        'departamento',
    ];
}
