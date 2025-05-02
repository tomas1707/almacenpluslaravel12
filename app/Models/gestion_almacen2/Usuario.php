<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use \PDOException;

class Usuario extends Model
{
    //El nombre de la conexión es extraido del archivo database.php, ubicado en la carpeta config
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'nombre_usuario',
        'correo_electronico',
        'contrasennia',
        'activo',
        'token_recuperacion',
        'token_expiracion',
        'rol_id',
    ];

    protected $hidden = [
        'contrasennia',
        'token_recuperacion',
    ];
    protected $casts = [
        'activo' => 'boolean',
        'fecha_creacion' => 'datetime',
        'token_expiracion' => 'datetime',
    ];
    public $timestamps = false; // Ya que la marca de tiempo de creación se maneja en la migración

    //Relación pertenece a Roles
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    ////Relación pertenece a muchos Proveedores
    public function ordenescompra(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, 'ordenescompra')
            ->withPivot('fecha_orden', 'fecha_esperada_recepcion', 'estado');
    }

    //Relación pertenece a muchos Proveedores
    public function recepciones(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, 'recepciones')
            ->withPivot('fecha_orden', 'fecha_esperada_recepcion', 'estado');
    }

    //*******************************************************************************************

    public function getAllUsuarios(){
        $resUsaurio=null;
        $status=500;

        try{
            $resUsaurio = $this->all();
        }
        catch (PDOException $e) {
            $status=500;
            $data=[
                'data'=>$resUsaurio,
                'message' => 'No se pudo conectar con el servidor de base de datos',
                'status'=>$status
            ];

            Log::emergency ('No se pudo conectar con el servidor de base de datos', [
                'message' => 'Error en la conexión con el servidor MySQL',
                'category' => 'server',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        }
        catch (QueryException $e) {
            $status=500;
            $data=[
                'data'=>$resUsaurio,
                'message' => 'No se pudo conectar con el servidor de base de datos',
                'status'=>$status
            ];

            Log::emergency ('No se pudo conectar con el servidor de base de datos', [
                'message' => 'Error con la consula',
                'category' => 'server',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        }

        if (!is_null($resUsaurio)){

            $status=200;
            $data=[
                'data'=>$resUsaurio,
                'message' => 'Muestra la lista de usuarios registrados',
                'status'=>$status
            ];

            Log::info('Mostrando todos los usuarios registrados', [
                'message' => 'Muestra la lista de usuarios registrados',
                'category' => 'data base',
                'exception' => 'null',
                'status' => $status
            ]);

            return response()->json($data, $status);

        }
        else{
            $status=200;

            $data=[
                'message' => 'No se encontraron usuarios registrados',
                'status'=>$status
            ];

            Log::error('No hay usuarios registrados', [
                'message' => 'No se encontraron usuarios registrados',
                'category' => 'data base',
                'exception' => 'null',
                'status' => $status
            ]);

            return response()->json($data, $status);
        }

    }
}
