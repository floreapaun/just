<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'administrator@justitie.portal',
            'password' => Hash::make('1234567890'),
        ]);

        DB::table('courts')->insert([
            ['name' => 'C1', 'judge' => 'Ion Dorel'],
            ['name' => 'C2', 'judge' => 'Alex Marcu'],
            ['name' => 'C3', 'judge' => 'Lucretia Vasile'],
            ['name' => 'C4', 'judge' => 'Florin Balin'],
            ['name' => 'C5', 'judge' => 'Maria Stefania'],
            ['name' => 'C6', 'judge' => 'Ionel Doru'],
        ]);

        DB::table('crimes')->insert([
              ['name' => 'Luarea de mita'],
              ['name' => 'Traficul de influenta'],
              ['name' => 'Cumpararea de influenta'],
              ['name' => 'Fapte savarsite de catre membrii instantelor de arbitraj sau in legatura cu acestia'],
              ['name' => 'Fapte savarsite de catre functionari straini sau in legatura cu acestia'],
              ['name' => 'Delapidare'],
              ['name' => 'Abuz in serviciu'],
              ['name' => 'Neglijenta in serviciu'],
              ['name' => 'Folosirea abuziva a functiei in scop sexual'],
              ['name' => 'Uzurparea functiei'],
              ['name' => 'Conflict de interese'],
              ['name' => 'Obtinere ilegala de fonduri'],
              ['name' => 'Deturnare de fonduri'],
              ['name' => 'Evaziune fiscala'],
              ['name' => 'Infractiuni asimilate infractiunilor de coruptie'],
              ['name' => 'Spalarea banilor'],
              ['name' => 'Infractiuni impotriva intereselor financiare ale Uniunii Europene'],
              ['name' => 'Masuri si exceptii dispuse de judecatorul de camera preliminara'],
              ['name' => 'Masuri preventive'],
              ['name' => 'Contestatii - Drepturi si Libertati'],
        ]);
    }
}
