<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Privilegio extends Model
{
    public $timestamps = false;
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'privilegios';
    protected $fillable = ['titulo_privilegio'];
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rolespermisos', 'privilegio_id', 'rol_id')
            ->withPivot('fecha_asignacion');
    }
    public function rolespermisos(): HasMany
    {
        return $this->hasMany(RolPermiso::class);
    }
}
