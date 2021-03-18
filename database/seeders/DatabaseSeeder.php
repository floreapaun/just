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
    }
}
