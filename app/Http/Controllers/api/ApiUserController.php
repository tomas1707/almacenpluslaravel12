<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\gestion_almacen2\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

// Importa la fachada Log para escribir en los archivos de registro

class ApiUserController extends Controller
{
    private Usuario $usuario;
    public function __construct(Usuario $usuario) //Concepto de inyeción de dependencias
    {
        $this->usuario = $usuario;
    }

    public function index(): JsonResponse{

        $RespuestaJson = $this->usuario->getAllUsuarios();

        return $RespuestaJson;

    }

    public function show(Request $request): JsonResponse{
        $idQueryParams = $request->query();

        $validarDatos = Validator::make($idQueryParams, [
            'id' => 'required|integer|min:1',
        ]);

        if ($validarDatos->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'status' => 400
            ], 400);
        }
        else
        {
            $RespuestaJson = $this->usuario->findUsuario($idQueryParams['id']);
            return $RespuestaJson;
        }

    }

    public function store(Request $request): JsonResponse{
        Log::info('Request Headers:', ['headers' => $request->headers->all()]); // Registra las cabeceras de la solicitud para depuración. El segundo argumento debe ser un array.
        Log::info('Request Content:', ['content' => $request->getContent()]); // Registra el cuerpo de la solicitud para depuración. El segundo argumento debe ser un array.

        // Asegurarse de que la solicitud sea en formato JSON
        if (!$request->isJson()) { // Verifica si la cabecera 'Content-Type' de la solicitud es 'application/json'.
            return response()->json(['message' => 'La solicitud debe ser en formato JSON', 'status' => 415], 415); // Devuelve una respuesta JSON con código de estado 415 (Unsupported Media Type) si no es JSON.
        }

        $jsonRequest = $request->json()->all(); // Obtiene todos los datos JSON del cuerpo de la solicitud como un array asociativo.
        Log::info('Datos JSON recibidos:', ['data' => $jsonRequest]); // Registra los datos JSON recibidos para depuración.

        // Define las reglas de validación para los campos requeridos en la solicitud JSON.
        $validarDatos = Validator::make($jsonRequest, [
            'nombre_completo' => 'required',
            'nombre_usuario' => 'required',
            'correo_electronico' => 'required|email|unique:usuarios',
            'contrasennia' => 'required',
        ]);

        // Verifica si la validación de los datos ha fallado.
        if ($validarDatos->fails()) {
            $errorData = [
                'message' => 'Error en la validación de datos',
                'error' => $validarDatos->errors(),
                'status' => 400,
            ];
            Log::error('Errores de validación:', $validarDatos->errors()->toArray()); // Registra los errores de validación detallados en el log.
            return response()->json($errorData, 400);
        } else {
            // Si la validación pasa, intenta crear un nuevo usuario en la base de datos.
            //*********************crateUsaurio
            $RespuestaJson = $this->usuario->crateUsaurio($jsonRequest);
            return $RespuestaJson;
        }
    }

    public function update(Request $request, $id): JsonResponse{
        Log::info('Request Headers:', ['headers' => $request->headers->all()]); // Registra las cabeceras de la solicitud para depuración. El segundo argumento debe ser un array.
        Log::info('Request Content:', ['content' => $request->getContent()]); // Registra el cuerpo de la solicitud para depuración. El segundo argumento debe ser un array.

        // Asegurarse de que la solicitud sea en formato JSON
        if (!$request->isJson()) { // Verifica si la cabecera 'Content-Type' de la solicitud es 'application/json'.
            return response()->json(['message' => 'La solicitud debe ser en formato JSON', 'status' => 415], 415); // Devuelve una respuesta JSON con código de estado 415 (Unsupported Media Type) si no es JSON.
        }

        $jsonRequest = $request->json()->all(); // Obtiene todos los datos JSON del cuerpo de la solicitud como un array asociativo.
        Log::info('Datos JSON recibidos:', ['data' => $jsonRequest]); // Registra los datos JSON recibidos para depuración.

        // Define las reglas de validación para los campos requeridos en la solicitud JSON.
        $validarDatos = Validator::make($jsonRequest, [
            'nombre_completo' => 'required',
            'nombre_usuario' => 'required',
            'correo_electronico' => 'required|email|unique:usuarios',
            'contrasennia' => 'required',
            'rol_id' => 'required',
            'activo' => 'required',
        ]);

        // Verifica si la validación de los datos ha fallado.
        if ($validarDatos->fails()) {
            $errorData = [
                'message' => 'Error en la validación de datos',
                'error' => $validarDatos->errors(),
                'status' => 400,
            ];
            Log::error('Errores de validación:', $validarDatos->errors()->toArray()); // Registra los errores de validación detallados en el log.
            return response()->json($errorData, 400);
        } else {
            // Si la validación pasa, intenta crear un nuevo usuario en la base de datos.
            //*********************crateUsaurio
            $RespuestaJson = $this->usuario->updateUsaurio($jsonRequest,$id);
            return $RespuestaJson;
        }
    }


    public function partialUpdate(Request $request, $id){
        Log::info('Request Headers:', ['headers' => $request->headers->all()]); // Registra las cabeceras de la solicitud para depuración. El segundo argumento debe ser un array.
        Log::info('Request Content:', ['content' => $request->getContent()]); // Registra el cuerpo de la solicitud para depuración. El segundo argumento debe ser un array.

        // Asegurarse de que la solicitud sea en formato JSON
        if (!$request->isJson()) { // Verifica si la cabecera 'Content-Type' de la solicitud es 'application/json'.
            return response()->json(['message' => 'La solicitud debe ser en formato JSON', 'status' => 415], 415); // Devuelve una respuesta JSON con código de estado 415 (Unsupported Media Type) si no es JSON.
        }

        $jsonRequest = $request->json()->all(); // Obtiene todos los datos JSON del cuerpo de la solicitud como un array asociativo.
        Log::info('Datos JSON recibidos:', ['data' => $jsonRequest]); // Registra los datos JSON recibidos para depuración.

        // Define las reglas de validación para los campos requeridos en la solicitud JSON.
        $validarDatos = Validator::make($jsonRequest, [
            'nombre_usuario' => 'required',
            'correo_electronico' => 'required|email|unique:usuarios',
            'contrasennia' => 'required',
        ]);

        // Verifica si la validación de los datos ha fallado.
        if ($validarDatos->fails()) {
            $errorData = [
                'message' => 'Error en la validación de datos',
                'error' => $validarDatos->errors(),
                'status' => 400,
            ];
            Log::error('Errores de validación:', $validarDatos->errors()->toArray()); // Registra los errores de validación detallados en el log.
            return response()->json($errorData, 400);
        } else {
            // Si la validación pasa, intenta crear un nuevo usuario en la base de datos.
            //*********************crateUsaurio
            $RespuestaJson = $this->usuario->partialUpdateUsuario($jsonRequest,$id);
            return $RespuestaJson;
        }
    }



    public function destroy($id) :JsonResponse{
        if (!$id) {
            return response()->json([
                'message' => 'ID del usuario no proporcionado en la URL',
                'status' => 400
            ], 400);
        }

        $RespuestaJson = $this->usuario->eliminarUsuario($id);
        return $RespuestaJson;
    }
}
