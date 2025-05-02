<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function index(){
        return view('podcast');
        //eturn "Esta es la página principal de los Podcast de TICS desde un controlador";
    }

    public function create(){
        return "aqui se mostrará un formulario para crear un podcast";
    }

    public function show($categoria){
        $mispodcastarray=[
            'comedia'=>[
                'la cotorrisa',
                'el sentido del humor',
                'nadie sabe nada',
                'leyendas kegendarias',
            ],
            'crimen real'=>[
                'caso 63',
                'relatos de la noche',
                'misterios sin resolver',
                'crimenes paranormales',
            ],
            'noticias y actualidad'=>[
                'el washington post',
                'hoy en el pais',
                'the daily',
                'asi como suena',
            ],
            'desarrollo personal'=>[
                'entiende tu mente',
                'dormir con historias',
                'el podcast de cristina mitre',
                'mas a lla de la rosa'
            ],
            'historia'=>[
                'memoria sur',
                'historia para tontos',
                'acontecer historico',
                'la contrahistoria',
            ],
        ];
        $categoria=strtolower($categoria);

        if (array_key_exists($categoria,$mispodcastarray))
            foreach ($mispodcastarray as $catClave=> $catValorArray)
                if (strcmp($catClave, $categoria) === 0){
                    echo "<p style='font-weight: bold; color: red;'> ".strtoupper($catClave)." </p>";
                    foreach ($catValorArray as $valor){
                        echo "<p style='font-weight: bold; color: red;'> &nbsp;&nbsp;&nbsp;$valor </p>";
                    }
                }
                else {
                    echo "<a href='/podcast/$catClave' ><p style='font-weight: color: black;'> $catClave </p></a>";
                }
        else
            echo "Categoria no existente";

        //return "Aquí utilizaré el id $parametro para mostrar información específica de la base de datos";
    }
}
