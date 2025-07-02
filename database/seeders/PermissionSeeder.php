<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos generales 
        $permissions = [
            // Módulo Usuarios
            'roles visualizar',
            'roles agregar',
            'roles permisos',
            'roles editar',
            'roles eliminar',
            'permisos visualizar',
            'permisos agregar',
            'permisos editar',
            'permisos eliminar',
            'usuarios visualizar',
            'usuarios agregar',
            'usuarios editar',
            'usuarios eliminar',
            // Módulo BIBLIOTECA
            'gestiones visualizar',
            'gestiones agregar',
            'gestiones editar',
            'gestiones eliminar',
            'salas visualizar',
            'salas agregar',
            'salas editar',
            'salas eliminar',
            'horarios visualizar',
            'horarios agregar',
            'horarios editar',
            'horarios eliminar',
            'estudiantes visualizar',
            'estudiantes agregar',
            'estudiantes editar',
            'estudiantes eliminar',
            'credenciales visualizar',
            'credenciales credencial',
            'credenciales agregar',
            'credenciales editar',
            'credenciales eliminar',
            'ingresos visualizar',
            'ingresos agregar',
            'ingresos editar',
            'ingresos eliminar',
            'asistencias visualizar',
            'asistencias agregar',
            'asistencias editar',
            'asistencias eliminar',
            // Módulo Reportes
            'reporte asistencias',
            'reporte ingresos',
            'reporte estudiantes',
        ];

        // Crear los permisos si no existen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
