<?php

namespace Database\Seeders;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::create([
            'name' => 'Ricardo',
            'middle_name' => 'Barrera',
            'last_name' => 'Sustaita',
            'email' => 'ricardobarreras1@outlook.com',
            'phone' => '5582786074',
            'rfc' => 'BASR790808370',
/*             'personable_type' => User::class, */
            'personable_type' => 'App\Models\Client',
            'personable_id' => 1,
        ]);
    }
}
