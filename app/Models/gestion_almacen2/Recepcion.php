<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recepcion extends Model
{
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'recepciones';

    protected $fillable = [
        'fecha_recepcion',
        'observaciones',
        'proveedor_id',
        'ordencompra_id',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_recepcion' => 'datetime',
    ];

    public $timestamps = false; // La marca de tiempo de creación se maneja en la migración (fecha_recepcion) y no tiene updated_at

    //Relación pertenece a Proveedores
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    //Relación pertenece a OrdenesCompra
    public function ordenCompra(): BelongsTo
    {
        return $this->belongsTo(Ordencompra::class);
    }

    //Relación pertenece a Usuarios
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}
