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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_producto')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('unidad_medida', 50)->nullable();
            $table->integer('stock_minimo')->nullable();
            $table->integer('stock_maximo')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
        });

        Schema::create('ajustesinventario', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_ajuste')->useCurrent();
            $table->integer('cantidad_anterior');
            $table->integer('cantidad_nueva');
            $table->string('motivo', 255)->nullable();

            $table->foreignId('producto_id')->constrained('productos');
            $table->foreignId('usuario_id')->constrained('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
        Schema::dropIfExists('ajustesinventario');
    }
};
