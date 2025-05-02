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
        Schema::create('ordenescompra', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->dateTime('fecha_orden')->useCurrent();
            $table->date('fecha_esperada_recepcion')->nullable();
            $table->string('estado', 50)->nullable(); // 'pendiente', 'recibida', 'cancelada'
            $table->foreignId('usuario_id')->constrained('usuarios');
        });

        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_recepcion')->useCurrent();
            $table->text('observaciones')->nullable();

            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('ordencompra_id')->constrained('ordenescompra');
            $table->foreignId('usuario_id')->constrained('usuarios');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenescompras');
        Schema::dropIfExists('recepciones');
    }
};
