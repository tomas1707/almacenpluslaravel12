<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $connection = 'MySql2_LaragonLocal';
    public $timestamps = false;

    protected $table = 'roles'; //La tabla de denomina Rol y tiene una realción muchos a muchos con Privilegios

    protected $fillable = [
        'nombre_rol',
        'activo'
    ];//fillable tendrá todos los campos (NO PRIMARY KEY, y NO FOREIGN KEY) que tenga la tabla.

    protected $casts = [
        'activo' => 'boolean'
    ];
    public function privilegios(): BelongsToMany //Relación Muchos a Muchos con la tabla Privilegio
    {//Con esta relación se genera una tabla pivote denominada rolespersmisos
        return $this->belongsToMany(Privilegio::class, 'rolespermisos', 'rol_id', 'privilegio_id')
            ->withPivot('fecha_asignacion');//withPivot contendrá los campos adicionales a las claves foráneas.
    }

    public function rolespermisos(): HasMany
    {
        return $this->hasMany(RolPermiso::class);
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class);
    }
}
