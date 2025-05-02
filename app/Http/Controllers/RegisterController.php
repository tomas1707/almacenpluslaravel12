<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmarCorreoMailable;


class RegisterController extends Controller
{
    public function create(){
        return view('RegisterViews.registrarusuario');
    }
    public function store(Request $request){
        $nombre=$request->nombre;
        $correo=$request->correo;
        $usuario=$request->usuario;
        $contrasennia=$request->contrasennia;
        $contraseniaCifrada = Hash::make($contrasennia);
        $MensajeError="";

        try{
            DB::connection('mysql')
                ->table('usuarios')
                ->insert([
                'nombre_completo' => $nombre,
                'nombre_usuario' => $usuario,
                'correo_electronico' => $correo,
                'contrasennia' => $contraseniaCifrada, // Insertar la contraseña cifrada
                'activo' => 0, // o 0, según sea necesario
                'id_rol' => 6
                ]);



            $MensajeError="Registro exitoso";

            Mail::to($correo)
                ->send(new ConfirmarCorreoMailable($nombre,$correo));

            return redirect('/login')
                ->with('sessionInsertado', 'true')
                ->with('mensaje',$MensajeError); //With envía en una session slash dos claves y sus valores

        }
        catch (\Swift_TransportException $e){
            $exito=false;

            return redirect('/register')
                ->with('sessionInsertado', 'false')
                ->with('mensaje',$MensajeError); //With envía en una session slash dos claves y sus valores
        }
        catch (\Exception $e){
            $exito=false;
            $MensajeError="Hubo un error en el servidor";
            return redirect('/register')
                ->with('sessionInsertado', 'false')
                ->with('mensaje',$MensajeError); //With envía en una session slash dos claves y sus valores
        }

    }

    public function ConfirmMail($correo)
    {
        //echo  "saludos $correo";
        DB::connection('mysql')->
        table('usuarios')
            ->where('correo_electronico','=', $correo)
            ->update(['activo' => 1]);


        return view('RegisterViews.mensajecorreoconfirmado',['correo' => $correo]);
    }
}
