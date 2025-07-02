<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alertas')->insert([
            [
                'hora' => '08:30:00',
                'fecha' => '2025-01-15',
                'mensaje' => 'Intento de acceso inválido'
            ]
        ]);
    }
}
