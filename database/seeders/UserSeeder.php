<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ADMINISTRADORES
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'Administrador'], ['guard_name' => 'web']);
        $roleSuperAdmin->syncPermissions(Permission::all());
        $admin = User::firstOrCreate([
            'ci' => '12345678',
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('12345678'),
            'estado' => true,
            'rol_id' => 1
        ]);

        if (!$admin->hasRole('Administrador')) {
            $admin->assignRole($roleSuperAdmin);
        }
        //ADMINISTRATIVOS
        DB::table('users')->insert([
            [
                'ci' => '589854',
                'nombres' => 'Maria',
                'apellidos' => 'Mendez',
                'email' => 'maria@gmail.com',
                'password' => Hash::make('12345678'),
                'estado' => true,
                'rol_id' => 2
            ],
        ]);
        //DOCENTES
        DB::table('users')->insert([
            [
                'ci' => '9653247',
                'nombres' => 'Josue',
                'apellidos' => 'Camacho',
                'email' => 'josue@gmail.com',
                'password' => Hash::make('12345678'),
                'estado' => true,
                'rol_id' => 3
            ],
        ]);

        //ESTUDIANTE
        DB::table('users')->insert([
            [
                'ci' => '9653587',
                'nombres' => 'Isai',
                'apellidos' => 'Mamani Calani',
                'email' => 'isai@gmail.com',
                'password' => Hash::make('12345678'),
                'estado' => true,
                'rol_id' => 4
            ],
        ]);
        DB::table('users')->insert([
            [
                'ci' => '45213',
                'nombres' => 'Joel',
                'apellidos' => 'Oronoz Mendez',
                'email' => 'joel@gmail.com',
                'password' => Hash::make('12345678'),
                'estado' => true,
                'rol_id' => 4
            ],
        ]);
        DB::table('users')->insert([
            [
                'ci' => '98632',
                'nombres' => 'Julia',
                'apellidos' => 'Cortez Mendez',
                'email' => 'julia@gmail.com',
                'password' => Hash::make('12345678'),
                'estado' => true,
                'rol_id' => 4
            ],
        ]);
    }
}
