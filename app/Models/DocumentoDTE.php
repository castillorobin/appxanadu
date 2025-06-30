<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoDTE extends Model
{
   protected $fillable = [
        'sello_recibido',
        'codigo_generacion',
        'numero_control',
        'factura',
    ];
}
