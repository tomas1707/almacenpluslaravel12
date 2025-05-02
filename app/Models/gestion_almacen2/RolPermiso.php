<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'rolespermisos';
    protected $fillable = ['rol_id', 'privilegio_id', 'fecha_asignacion'];
    public $timestamps = false;
    public $incrementing = false; // Indicamos que no tiene una llave primaria autoincremental


    public function rol()//Relación pertence a Roles
    {
        return $this->belongsTo(Rol::class);
    }

    public function privilegio() //Relación pertenece a Privilegios
    {
        return $this->belongsTo(Privilegio::class);
    }
}
