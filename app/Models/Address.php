<?php

namespace App\Models;

use App\Traits\ConvertsToUppercase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;
    protected $fillable = [
        'tipo_de_domicilio',
        'tipo_vialidad',
        'nombre_vialidad',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'localidad',
        'municipio',
        'ciudad',
        'entidad',
        'codigo_postal',
        'pais_nombre',
        'referencias',
    ];

    use ConvertsToUppercase;
    protected array $uppercaseAttributes = [
        'tipo_vialidad',
        'nombre_vialidad',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'localidad',
        'municipio',
        'ciudad',
        'entidad',
        'pais_nombre',
        'referencias'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'address_id');
    }
    
}
