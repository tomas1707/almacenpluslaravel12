<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_rol',50)->unique();
        });

        Schema::create('privilegios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_privilegio')->unique();
        });

        // Insertar datos después de crear la tabla

        Schema::create('rolespermisos', function (Blueprint $table) {
            $table->timestamp('fecha_asignacion')->useCurrent();

            $table->foreignId('rol_id')->constrained('roles');
            $table->foreignId('privilegio_id')->constrained('privilegios');
            $table->primary(['rol_id', 'privilegio_id']); // Esta es una clave primaria compuesta, pero se puede omitir
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('privilegios');
        Schema::dropIfExists('rolespermisos');
    }
};
