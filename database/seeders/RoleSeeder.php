<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Administrador', 'descripcion' => 'Acceso total', 'guard_name' => 'web'],
            ['name' => 'Administrativo', 'descripcion' => 'Acceso parcial', 'guard_name' => 'web'],
            ['name' => 'Docente', 'descripcion' => 'Acceso parcial', 'guard_name' => 'web'],
            ['name' => 'Estudiante', 'descripcion' => 'Acceso parcial', 'guard_name' => 'web'],
            ['name' => 'Invitado', 'descripcion' => 'Acceso limitado', 'guard_name' => 'web'],
        ]);
    }
}
