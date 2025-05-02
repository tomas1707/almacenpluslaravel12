<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovimientoController;

//Route::get('/', [HomeController::class, 'index']);
Route::get('/', HomeController::class);

Route::get("/pruebas", function(){
    return view("blank");
});

Route::prefix("/login")->group(function(){ //Rutas para el login
    //Rutas para el login
    /*Paso 1*/Route::get('/', [AuthController ::class, 'showLoginForm'])->name('login');
    /*Paso 2*/Route::post('/post', [AuthController ::class, 'login'])->name('login.post');
    /*Paso 3*/Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix("/password")->group(function(){//Rutas para la recuperación de contraseña
    //Rutas para la recuperación de contraseña
    /*Paso 1*/Route::get('/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.request');
    /*Paso 2*/Route::put('/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    /*Paso 3*/Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetFormWithToken'])->name('password.reset');
    /*Paso 4*/Route::put('/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::prefix("/profile")->group(function(){//Rutas para el registro de nuevos usuarios
    Route::get('/', [ProfileController ::class, 'showProfileForm'])->name('profile');
    Route::get('/{id}/edit', [ProfileController ::class, 'edit'])->name('profile.edit');
    Route::put('/{id}', [ProfileController ::class, 'update'])->name('profile.update');
});

Route::prefix('productos')->group(function() { //Rutas para la creación del CRUD productos
    //Rutas para el CRUD de Productos
    Route::get('/', [ProductosController::class, 'index'])->name('productos.index');
    Route::get('/create', [ProductosController::class, 'create'])->name('productos.create');
    Route::post('/create', [ProductosController::class, 'store'])->name('productos.store');
    Route::get('/search', [ProductosController::class, 'search'])->name('productos.search');
    Route::get('/{id}', [ProductosController::class, 'show'])->name('productos.show');
    Route::get('/{id}/edit', [ProductosController::class, 'edit'])->name('productos.edit');
    Route::put('/{id}', [ProductosController::class, 'update'])->name('productos.update');
    Route::delete('/{id}', [ProductosController::class, 'destroy'])->name('productos.destroy');
});

Route::prefix('/movimientos')->group(function () {
    // Rutas para el CRUD de entradas y salidas
    Route::get('/', [MovimientoController::class, 'index'])->name('movimientos.index'); // Listar movimientos
    Route::get('/create', [MovimientoController::class, 'create'])->name('movimientos.create'); // Mostrar formulario de creación
    Route::post('/', [MovimientoController::class, 'store'])->name('movimientos.store'); // Guardar nuevo movimiento
    Route::get('/{movimiento}', [MovimientoController::class, 'show'])->name('movimientos.show'); // Mostrar detalles del movimiento
    Route::get('/{movimiento}/edit', [MovimientoController::class, 'edit'])->name('movimientos.edit'); // Mostrar formulario de edición
    Route::put('/{movimiento}', [MovimientoController::class, 'update'])->name('movimientos.update'); // Actualizar movimiento
    Route::delete('/{movimiento}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy'); // Eliminar movimiento
});

Route::prefix('/register')->group(function () {
    // Rutas para el CRUD de Usuarios
    /*Paso 1*/Route::get('/', [RegisterController::class, 'create'])->name('register.create'); //Reemplaza showRegistrationForm
    /*Paso 2*/Route::post('/post', [RegisterController::class, 'store'])->name('register.store'); //Reemplaza register
    /*Paso 3*/Route::get('/{correo}/confirmar', [RegisterController::class, 'ConfirmMail'])->name('register.confirmmail'); //Reemplaza showRegistrationForm
});







//Route::prefix('podcast')->group(function(){
//    Route::get('/', [PodcastController::class, 'index']);
//    Route::get('/create', [PodcastController::class, 'create']);
//    Route::get('{parametro}', [PodcastController::class, 'show']);
//
//    Route::get('{parametro}/{categoria?}', function ($parametro,?string $categoria=null) {
//        if (is_null($categoria))
//            return "Podcast de la carrera de TICS titulado $parametro";
//        else
//            return "Podcast de la carrera de TICS titulado $parametro de la categoria $categoria";
//    });
//});

//Route::get('/', function () { //Función Call Back o función anónima
//    //return "Hola Mundo";
//    //return view('welcome');
//});

//Route::get('/podcast/{parametro}', function ($parametro) {
//    return "Podcast de la carrera de TICS titulado $parametro";
//});
//
//Route::get('/podcast/{parametro}/{categoria}', function ($parametro,$categoria) {
//    return "Podcast de la carrera de TICS titulado $parametro de la categoria $categoria";
//});



//Route::get('/podcast2/populares/}', function () {
//    return "Esta es la lista de podcast de TIC mas populares del sitio";
//});

//Route::get('/podcast', function () {
//    return "este es mi primer PodCast de la carrera de TICS";
//});


//Route::post('/metodopost', function () {
//
//});
//
//Route::put('/metodoput', function () {
//
//});
//
//Route::delete('/metododelete', function () {
//
//});
//
//Route::get('/metodohead', function () {
//    $response = Http::head('https://profmatiasgarcia.com.ar/uploads/tutoriales/Laravel-Clase1.pdf');
//
//    if ($response->successful()) {
//        // El recurso existe
//        $TipoArchivo = $response->header('Content-Type');
//        $partes = explode("/", $TipoArchivo);
//        $extension=end($partes);
//
//        $TamannioArchivo = $response->header('Content-Length');
//        $TamannioArchivo=$TamannioArchivo/1024;
//
//        echo 'Tipo de contenido: ' . $extension . "<br>";
//        echo 'Tamaño del archivo: ' . round($TamannioArchivo,0) . " kb <br>";
//
//    } else {
//        // El recurso no existe o ha ocurrido un error
//        echo 'Error: ' . $response->status() . "\n";
//    }
//});
//
//Route::options('/metodooptions', function () {
//
//});
//
//Route::patch('/metodopatch', function () {
//
//});


