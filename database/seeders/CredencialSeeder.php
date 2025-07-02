<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CredencialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('credenciales')->insert([
            [
                'codigo' => '0001',
                'foto_qr' => null,
                'fecha_emicion' => '16-03-2025',
                'fecha_expiracion' => '16-03-2026',
                'estado' => true,
                'usuario_id' => 1,
                'gestion_id' => 1
            ]
        ]);

        DB::table('credenciales')->insert([
            [
                'codigo' => '0002',
                'foto_qr' => null,
                'fecha_emicion' => '2025-03-16',
                'fecha_expiracion' => '2026-03-16',
                'estado' => true,
                'usuario_id' => 2,
                'gestion_id' => 1
            ]
        ]);
    }
}
