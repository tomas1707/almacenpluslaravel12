<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('nombre_usuario')->unique();
            $table->string('correo_electronico')->unique();
            $table->string('contrasennia'); // Laravel usará hash como bcrypt
            $table->boolean('activo')->default(false);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->string('token_recuperacion')->unique()->nullable();
            $table->dateTime('token_expiracion')->nullable();

            $table->foreignId('rol_id')->constrained('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
