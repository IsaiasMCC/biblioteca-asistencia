<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('horarios')->insert([
            [
                'lunes' => true,
                'martes' => true,
                'miercoles' => true,
                'jueves' => true,
                'viernes' => true,
                'sabado' => false,
                'domingo' => false,
                'hora_inicio' => '08:00:00',
                'hora_fin' => '18:00:00',
                'sala_id' => 1
            ]
        ]);
        DB::table('horarios')->insert([
            [
                'lunes' => true,
                'martes' => true,
                'miercoles' => true,
                'jueves' => true,
                'viernes' => true,
                'sabado' => false,
                'domingo' => false,
                'hora_inicio' => '09:00:00',
                'hora_fin' => '18:00:00',
                'sala_id' => 2
            ]
        ]);
    }
}
