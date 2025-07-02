<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gestiones')->insert([
            ['anio' => '2025', 'semestre' => '1'],
            ['anio' => '2025', 'semestre' => '2']
        ]);
    }
}
