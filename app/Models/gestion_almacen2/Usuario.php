<?php

namespace App\Models\gestion_almacen2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use \PDOException;
use \InvalidArgumentException;
use Illuminate\Http\JsonResponse;

class Usuario extends Model
{
    //El nombre de la conexión es extraido del archivo database.php, ubicado en la carpeta config
    protected $connection = 'MySql2_LaragonLocal';
    protected $table = 'usuarios';

    protected $fillable = [
        'id',
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

    public function getAllUsuarios():JsonResponse{
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
            $status=404;

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

    public function findUsuario($id):JsonResponse{
        $resUsaurio=null;
        $status=500;

        try{
            $resUsaurio = $this->find($id);
        }
        catch (InvalidArgumentException  $e) {
            $status=500;
            $data=[
                'data'=>$resUsaurio,
                'message' => 'Error en la conexión de base de datos',
                'status'=>$status
            ];

            Log::emergency ('Error en la conexión de base de datos', [
                'message' => 'Hubo un error con la conexión al servicio de base de datos',
                'category' => 'server',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);

        }
        catch (PDOException $e) {
            $status=500;
            $data=[
                'data'=>$resUsaurio,
                'message' => 'Error en la conexión con sl servicio de datos',
                'status'=>$status
            ];

            Log::emergency ('Error en la conexión con sl servicio de datos', [
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
                'message' => 'Error con la consulta',
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
                'message' => 'Muestra los datos del usuario solicitado',
                'status'=>$status
            ];

            Log::info('Muestra los datos del usuario solicitado', [
                'message' => 'Muestra los datos del usuario solicitado',
                'category' => 'data base',
                'exception' => 'null',
                'status' => $status
            ]);

            return response()->json($data, $status);

        }
        else{
            $status=404;

            $data=[
                'message' => 'No se encontró registro del id compartido',
                'status'=>$status
            ];

            Log::error('No se encontró registro del id compartido', [
                'message' => 'No se encontró registro del id compartido',
                'category' => 'data base',
                'exception' => 'null',
                'status' => $status
            ]);

            return response()->json($data, $status);
        }

    }

    public function crateUsaurio($jsonRequest):JsonResponse{
        $status=500;
        try {
            $resUsuario = Usuario::create([
                'nombre_completo' => $jsonRequest['nombre_completo'],
                'nombre_usuario' => $jsonRequest['nombre_usuario'],
                'correo_electronico' => $jsonRequest['correo_electronico'],
                'contrasennia' => Hash::make($jsonRequest['contrasennia']),
                'activo' => false,
                'rol_id' => 3,
            ]);

            // Verifica si el usuario fue creado exitosamente.
            if ($resUsuario) {
                $status=201;

                $data = [
                    'Usuario' => $resUsuario,
                    'message' => 'Usuario creado correctamente',
                    'status' => $status,
                ];

                Log::info('Usuario creado', [
                    'message' => 'Usuario creado',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            } else {
                $status=400;
                $data = [
                    'message' => 'Error al crear el usuario', // Mensaje de error genérico al crear el usuario.
                    'status' => $status, // Código de estado HTTP 500 (Internal Server Error) indicando un problema del lado del servidor.
                ];

                Log::error('Error al crear el usuario en la base de datos', [
                    'message' => 'Error al crear el usuario en la base de datos',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            }
        } catch (QueryException $e) {
            // Captura excepciones relacionadas con la base de datos (por ejemplo, violación de clave única no capturada por la validación).

            $data = [
                'message' => 'Error de base de datos al crear usuario', // Mensaje de error genérico al crear el usuario.
                'status' => $status, // Código de estado HTTP 500 (Internal Server Error) indicando un problema del lado del servidor.
            ];

            Log::critical('Error de base de datos al crear usuario', [
                'message' => 'Error de base de datos al crear usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status); // Devuelve una respuesta JSON con el error de la base de datos y el código de estado 500.
        } catch (\Exception $e) {
            // Captura otras excepciones inesperadas que puedan ocurrir durante el proceso.

            $data = [
                'message' => 'Error de base de datos al crear usuario', // Mensaje de error genérico al crear el usuario.
                'status' => $status, // Código de estado HTTP 500 (Internal Server Error) indicando un problema del lado del servidor.
            ];

            Log::critical('Error inesperado al crear usuario:', [
                'message' => 'Error inesperado al crear usuario:',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);

        }
    }

    public function updateUsaurio($jsonRequest,$id):JsonResponse{
        $status = 500;
        try {
            // Buscar al usuario existente por su ID
            $usuario = Usuario::find($id);

            if ($usuario) {
                // Actualiza los campos necesarios

                $usuario->nombre_usuario = $jsonRequest['nombre_usuario'];
                $usuario->correo_electronico = $jsonRequest['correo_electronico'];

                // Solo actualiza la contraseña si viene en la solicitud
                if (!empty($jsonRequest['contrasennia'])) {
                    $usuario->contrasennia = Hash::make($jsonRequest['contrasennia']);
                }

                // Guardar los cambios
                $usuario->save();

                $status = 200;
                $data = [
                    'Usuario' => $usuario,
                    'message' => 'Usuario actualizado correctamente',
                    'status' => $status,
                ];

                Log::info('Usuario actualizado', [
                    'message' => 'Usuario actualizado',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            } else {
                $status = 404;
                $data = [
                    'message' => 'Usuario no encontrado',
                    'status' => $status,
                ];

                Log::warning('Usuario no encontrado para actualizar', [
                    'message' => 'Usuario no encontrado para actualizar',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            }
        } catch (QueryException $e) {
            $data = [
                'message' => 'Error de base de datos al actualizar usuario',
                'status' => $status,
            ];

            Log::critical('Error de base de datos al actualizar usuario', [
                'message' => 'Error de base de datos al actualizar usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        } catch (\Exception $e) {
            $data = [
                'message' => 'Error inesperado al actualizar usuario',
                'status' => $status,
            ];

            Log::critical('Error inesperado al actualizar usuario', [
                'message' => 'Error inesperado al actualizar usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        }

    }

    public function partialUpdateUsuario($jsonRequest,$id):JsonResponse{
        $status = 500;
        try {
            // Buscar al usuario existente por su ID
            $usuario = Usuario::find($id);

            if ($usuario) {
                // Actualiza los campos necesarios
                $usuario->nombre_completo = $jsonRequest['nombre_completo'];
                $usuario->nombre_usuario = $jsonRequest['nombre_usuario'];
                $usuario->correo_electronico = $jsonRequest['correo_electronico'];

                // Solo actualiza la contraseña si viene en la solicitud
                if (!empty($jsonRequest['contrasennia'])) {
                    $usuario->contrasennia = Hash::make($jsonRequest['contrasennia']);
                }
                $usuario->activo = $jsonRequest['activo'];
                $usuario->rol_id = $jsonRequest['rol_id'];

                // Guardar los cambios
                $usuario->save();

                $status = 200;
                $data = [
                    'Usuario' => $usuario,
                    'message' => 'Usuario actualizado correctamente',
                    'status' => $status,
                ];

                Log::info('Usuario actualizado', [
                    'message' => 'Usuario actualizado',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            } else {
                $status = 404;
                $data = [
                    'message' => 'Usuario no encontrado',
                    'status' => $status,
                ];

                Log::warning('Usuario no encontrado para actualizar', [
                    'message' => 'Usuario no encontrado para actualizar',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            }
        } catch (QueryException $e) {
            $data = [
                'message' => 'Error de base de datos al actualizar usuario',
                'status' => $status,
            ];

            Log::critical('Error de base de datos al actualizar usuario', [
                'message' => 'Error de base de datos al actualizar usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        } catch (\Exception $e) {
            $data = [
                'message' => 'Error inesperado al actualizar usuario',
                'status' => $status,
            ];

            Log::critical('Error inesperado al actualizar usuario', [
                'message' => 'Error inesperado al actualizar usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        }

    }

    public function eliminarUsuario($id)
    {
        $status = 500;

        // Obtener el ID desde la query string

        try {
            $usuario = Usuario::find($id);

            if ($usuario) {
                $usuario->delete();

                $status = 200;
                $data = [
                    'message' => 'Usuario eliminado correctamente',
                    'status' => $status
                ];

                Log::info('Usuario eliminado', [
                    'message' => 'Usuario eliminado correctamente',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            } else {
                $status = 404;
                $data = [
                    'message' => 'Usuario no encontrado',
                    'status' => $status
                ];

                Log::warning('Intento de eliminar usuario no encontrado', [
                    'message' => 'Usuario no encontrado para eliminar',
                    'category' => 'data base',
                    'exception' => 'null',
                    'status' => $status
                ]);

                return response()->json($data, $status);
            }

        } catch (QueryException $e) {
            $data = [
                'message' => 'Error de base de datos al eliminar usuario',
                'status' => $status,
            ];

            Log::critical('Error de base de datos al eliminar usuario', [
                'message' => 'Error de base de datos al eliminar usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);

        } catch (\Exception $e) {
            $data = [
                'message' => 'Error inesperado al eliminar usuario',
                'status' => $status,
            ];

            Log::critical('Error inesperado al eliminar usuario', [
                'message' => 'Error inesperado al eliminar usuario',
                'category' => 'data base',
                'exception' => $e->getMessage(),
                'status' => $status
            ]);

            return response()->json($data, $status);
        }
    }


}
