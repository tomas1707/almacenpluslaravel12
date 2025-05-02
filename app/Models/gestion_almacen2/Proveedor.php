<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proveedor extends Model
{
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'correo_electronico',
        'rfc',
    ];

    public $timestamps = false; // Ya que la marca de tiempo de creación se maneja en la migración

    /**
     * Los usuarios que han realizado órdenes de compra a este proveedor.
     */
    public function proveedoresUsuarios_OrdenesCompra(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'ordenescompra')
            ->withPivot('fecha_orden', 'fecha_esperada_recepcion', 'estado');
    }

    /**
     * Los usuarios que han realizado recepciones de productos de este proveedor.
     */
    public function proveedoresUsuarios_Recepciones(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'recepciones')
            ->withPivot('fecha_recepcion', 'observaciones');
    }


}
