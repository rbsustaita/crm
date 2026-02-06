<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    protected $fillable = [
        'numero_solicitud',
        'client_id',
        'fecha_solicitud',
        'norma_aplicable',
        'servicio_solicitado',
        'direccion_fiscal',
    ];
}
