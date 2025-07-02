<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ISAI
        DB::table('ingresos')->insert([
            [
                'hora' => '08:30:00',
                'fecha' => '2025-01-15',
                'credencial_id' => 1,
                'sala_id' => 1
            ]
        ]);

        //JOEL
        DB::table('ingresos')->insert([
            [
                'hora' => '08:30:00',
                'fecha' => '2025-01-15',
                'credencial_id' => 2,
                'sala_id' => 1
            ]
        ]);
    }
}
