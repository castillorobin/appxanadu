<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class DocumentoDTE extends Model {
protected $fillable = [
'sello_recibido',
'codigo_generacion',
'numero_control',
'factura',
'fecha_generacion',
'tipo_dte',
'json_firmado_path',
'json_original_path',
'json_legible_path',
'pdf_path',
];
}