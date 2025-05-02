<?php

namespace Database\Seeders;

use App\Models\gestion_almacen2\Privilegio;
use Illuminate\Database\Seeder;

class PrivilegioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Privilegio::insert([
            ['titulo_privilegio' => 'Registrar usuarios'],
            ['titulo_privilegio' => 'Editar usuarios'],
            ['titulo_privilegio' => 'Eliminar usuarios'],
            ['titulo_privilegio' => 'Ver lista de usuarios'],
            ['titulo_privilegio' => 'Registrar Roles'],
            ['titulo_privilegio' => 'Editar Roles'],
            ['titulo_privilegio' => 'Eliminar Roles'],
            ['titulo_privilegio' => 'Ver lista de Roles'],
            ['titulo_privilegio' => 'Registrar Permisos'],
            ['titulo_privilegio' => 'Editar Permisos'],
            ['titulo_privilegio' => 'Eliminar Permisos'],
            ['titulo_privilegio' => 'Ver lista de Permisos'],
            ['titulo_privilegio' => 'Registrar Productos'],
            ['titulo_privilegio' => 'Editar Productos'],
            ['titulo_privilegio' => 'Eliminar Productos'],
            ['titulo_privilegio' => 'Ver lista de Productos'],
            ['titulo_privilegio' => 'Registrar Proveedores'],
            ['titulo_privilegio' => 'Editar Proveedores'],
            ['titulo_privilegio' => 'Eliminar Proveedores'],
            ['titulo_privilegio' => 'Ver lista de Proveedores'],
        ]);
    }
}
