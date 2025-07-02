<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('salas')->insert([
            [
                'nombre' => 'Biblioteca Ficct',
                'capacidad' => '100',
                'ubicacion' => 'Modulo 236',
                'estado' => true
            ]
        ]);
        DB::table('salas')->insert([
            [
                'nombre' => 'Laboratorio Redes',
                'capacidad' => '50',
                'ubicacion' => 'Campus Modulo 1',
                'estado' => true
            ]
        ]);
    }
}
