<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('AuthViews.InicioSesion');
    }

    public function login(Request $request)
    {

        $usuario = $request->usuario;
        $pass = $request->contrasennia;

        $resUsuario = DB::connection('mysql')->
        table('usuarios')
            ->select('id', 'nombre_completo', 'contrasennia', 'activo')
            ->where('nombre_usuario', '=', $usuario)
            ->first();

        //Si el tipo de dato del campo activo es entero, no es necesario convertir a entero en laravel
        //Laravel identifica el tipo de dato y así declara la variable.
        if ($resUsuario && Hash::check($pass, $resUsuario->contrasennia)) {
            if (intval($resUsuario->activo) == 1) {
//              echo "Coreo: $correo <br>";
//              echo "Pass: $pass <br>";
//              $passCifrado=Hash::make($pass);
//              echo "Pass Hash: $passCifrado <br>";
                session()->put('id', $resUsuario->id);
                session()->put('nombreCompleto', $resUsuario->nombre_completo);
                return redirect('/profile');
                //$token = str::uuid()->toString(); //IIID Universally Unique Identifier
                //$profileReact="http://localhost:5173/?token=' . $token;";
                //return redirect()->away($profileReact);
            } else {
                return redirect('/login')
                    ->with('loginCorecto', 'false')
                    ->with('mensaje', 'No has confirmado tu correo');
            }
        } else {
            return redirect('/login')
                ->with('loginCorecto', 'false')
                ->with('mensaje', 'Usuario o contraseña incorrectos');
        }
    }

    public function logout()
    {
        session()->forget('id');
        session()->forget('nombreCompleto');
        return redirect('/login');
    }
}
