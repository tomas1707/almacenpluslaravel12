<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Codificador;

class HomeController extends Controller
{
//    public function index(){
//        return "Página principal del podcast de TICS desde un controlador";
//    }

    public function __invoke(){
    return view("welcome");

        //$roles = DB::select('SELECT * FROM roles WHERE id = ?', [$id]);
        //DB::insert('INSERT INTO roles (nombre_rol) VALUES (?)', ['Residente']);
        //DB::update('UPDATE roles SET nombre_rol = ? WHERE id = ?', ['Servicio Social', 7]);
        //DB::delete('DELETE FROM roles WHERE id = ?', [7]);
        //dd($usuarios);
        //return $roles;
        //return "Página principal del podcast de TICS desde un controlador";
    }
}
