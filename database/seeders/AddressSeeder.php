<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $address = new Address();
        $address->client_id = 1; // Asignar el ID del cliente correspondiente
        $address->tipo_de_domicilio = 'DOMICILIO FISCAL';
        $address->tipo_vialidad = 'CALLE';
        $address->nombre_vialidad = 'JUÁREZ';
        $address->numero_exterior = '123';
        $address->numero_interior = 'A';
        $address->colonia = 'CENTRO';
        $address->municipio = 'CUAUHTÉMOC';
        $address->entidad = 'CDMX';
        $address->codigo_postal = '06000';
        $address->pais_nombre = 'MÉXICO';
        $address->referencias = 'CERCA DEL PARQUE';
        // Save the address to the database
        $address->save();
        // You can create more addresses as needed

    }
}
