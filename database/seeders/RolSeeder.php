<?php

namespace Database\Seeders;

use App\Models\gestion_almacen2\Rol;
use Illuminate\Database\Seeder;


class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::insert([
            ['nombre_rol' => 'Administrador'],
            ['nombre_rol' => 'Gerente de Almacén'],
            ['nombre_rol' => 'Invitado'],
            ['nombre_rol' => 'Operario de Almacén'],
            ['nombre_rol' => 'Supervisor de Inventario'],
            ['nombre_rol' => 'Vendedor'],
        ]);
    }
}
