<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            GestionSeeder::class,
            EstudianteSeeder::class,
            CredencialSeeder::class,
            SalaSeeder::class,
            HorarioSeeder::class,
            // AsistenciaSeeder::class,
            // IngresoSeeder::class,
            // SalidaSeeder::class,
            // AlertaSeeder::class,
        ]);
    }
}
