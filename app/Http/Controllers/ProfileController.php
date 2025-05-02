<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfileForm(){
        //Formulario del cpanel para mostrar profile
        if (session()->has('nombreCompleto')) {
            $nomnreCompleto=session()->get('nombreCompleto');
            return view('ProfileViews.perfildeusuario',['nomnreCompleto'=>$nomnreCompleto]);
        }
        else
            return redirect('/login')
                ->with('loginCorecto', 'false')
                ->with('mensaje', 'Su sesión ha caducado');
    }

    public function edit($id){

    }

    public function update(Request $request,$id){
        //Funcionalidad para actualizar los datos del usaurios medainte el profile
    }
}
