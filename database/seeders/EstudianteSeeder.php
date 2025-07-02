<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estudiantes')->insert([
            [
                'registro' => '217171508',
                'telefono' => '75845268',
                'email' => 'isaimamanicalani@uagrm.edu.com',
                'codigo_carrera' => 'INF320',
                'carrera' => 'Ingeniería Informática',
                'genero' => 'masculino',
                'foto_url' => null,
                'estado' => true,
                'user_id' => 4
            ]
        ]);
        DB::table('estudiantes')->insert([
            [
                'registro' => '217178562',
                'telefono' => '96587254',
                'email' => 'joeloronoz@uagrm.edu.com',
                'codigo_carrera' => 'RED300',
                'carrera' => 'Ingeniería en Redes y Telecomunicaciones',
                'genero' => 'masculino',
                'foto_url' => null,
                'estado' => true,
                'user_id' => 5
            ]
        ]);
    }
}
