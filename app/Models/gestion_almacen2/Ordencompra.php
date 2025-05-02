<?php

namespace App\Models\gestion_almacen2;

use App\Models\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ordencompra extends Model
{
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'ordenescompra';
    protected $fillable = [
        'proveedor_id',
        'fecha_orden',
        'fecha_esperada_recepcion',
        'estado',
        'usuario_id',
    ];
    protected $casts = [
        'fecha_orden' => 'datetime',
        'fecha_esperada_recepcion' => 'date',
    ];
    public $timestamps = false; // Ya que la marca de tiempo de creación se maneja en la migración (fecha_orden) y no tiene updated_at

    //Relación pertenece a Proveedor
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    //Relación pertenece a Usuarios
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    //Relación tiene muchos con Recepciones
    public function recepciones(): HasMany
    {
        return $this->hasMany(Recepcion::class);
    }
}
