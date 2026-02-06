<?php

namespace Database\Seeders;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name' => 'PVH MÉXICO, S.A. DE C.V.',
            'trade_name' => 'PHILIP VAN HEUSSEN',
            'tax_id' => 'PVH250311UH3',
            'tipo_persona' => 'Moral',
            'sector' => 'Terciario',
            'sub_category' => 'Comercio',
            'website' => 'https://www.pvh.com/',
            'address_id' => 1,
            'active' => true,
            'person_id' => 1,
            'user_id' => 1,
            'notes' => 'Cliente importante en el sector de la moda y confección.',
        ]);
    }
}
