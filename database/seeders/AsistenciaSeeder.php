<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asistencias')->insert([
            [
                'fecha' => '2025-01-15',
                'hora' => '08:30:00',
                'credencial_id' => 1,
                'sala_id' => 1,
            ]
        ]);
    }
}
