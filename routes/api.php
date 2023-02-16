<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\videojuegos\PersonaController as VideoPersona;
use App\Http\Controllers\videojuegos\JuegoController;
use App\Http\Controllers\videojuegos\GeneroController;
use App\Http\Controllers\videojuegos\ConsolaController;
use App\Http\Controllers\videojuegos\CrearUsuarioController;
use App\Http\Controllers\videojuegos\RelacionController;
use App\Http\Controllers\videojuegos\RolController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix("/httpEx")->group(function(){
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post("/persona", [VideoPersona::class, "create"]);
        Route::put("/persona/{id}", [VideoPersona::class, "update"])->where("id", "[0-9]+");
        Route::get("/persona/info", [VideoPersona::class, "index"]);
        Route::delete("/persona/{id}", [VideoPersona::class, "delete"])->where("id", "[0-9]+");
        Route::get("/logout", [CrearUsuarioController::class, "logout"]);

        /////////////////
        Route::post("/personaHTTP", [VideoPersona::class, "createHTTP"]);
        Route::put("/personaHTTP/{id}", [VideoPersona::class, "updateHTTP"])->where("id", "[0-9]+");
        Route::delete("/personaHTTP/{id}", [VideoPersona::class, "deleteHTTP"])->where("id", "[0-9]+");


        Route::post("/consola", [ConsolaController::class, "create"]);
        Route::put("/consola/{id}", [ConsolaController::class, "update"])->where("id", "[0-9]+");
        Route::get("/consola/info", [ConsolaController::class, "index"]);
        Route::delete("/consola/{id}", [ConsolaController::class, "delete"])->where("id", "[0-9]+");
        ////////////////////////////////////
        Route::post("/consolaHTTP", [ConsolaController::class, "createHTTP"]);
        Route::put("/consolaHTTP/{id}", [ConsolaController::class, "updateHTTP"])->where("id", "[0-9]+");
        Route::delete("/consolaHTTP/{id}", [ConsolaController::class, "deleteHTTP"])->where("id", "[0-9]+");
    });
    
    Route::post("/registro", [CrearUsuarioController::class, "crearUsuario"]);
    Route::post("/registroHTTP", [CrearUsuarioController::class, "crearUsuarioHTTP"]);
    Route::post("/iniciarSesion", [CrearUsuarioController::class, "logearUsuario"]);
    Route::post("/mensageVerificacion", [CrearUsuarioController::class, "sendMenssage"])->name('hola')->middleware('signed');
    Route::post("/verificacionCuenta", [CrearUsuarioController::class, "verifyAccount"])->name('codigoC')->middleware('signed');
    
    Route::post("/relacionjp", [RelacionController::class, "juegosPersonas"]);
    Route::post("/addRol", [RolController::class, "addRol"]);



    ///////////////////////////////////////////////////////////////
    Route::post("/juego", [JuegoController::class, "create"]);
    Route::put("/juego/{id}", [JuegoController::class, "update"])->where("id", "[0-9]+");
    Route::get("/juego/info", [JuegoController::class, "index"]);
    Route::delete("/juego/{id}", [JuegoController::class, "delete"])->where("id", "[0-9]+");
    ///////////////
    Route::post("/juegoHTTP", [JuegoController::class, "createHTTP"]);
    Route::put("/juegoHTTP/{id}", [JuegoController::class, "updateHTTP"])->where("id", "[0-9]+");
    Route::delete("/juegoHTTP/{id}", [JuegoController::class, "deleteHTTP"])->where("id", "[0-9]+");

    Route::post("/genero", [GeneroController::class, "create"]);
    Route::put("/genero/{id}", [GeneroController::class, "update"])->where("id", "[0-9]+");
    Route::get("/genero/info", [GeneroController::class, "index"]);
    ///////////////////////////////////////////
    Route::post("/generoHTTP", [GeneroController::class, "createHTTP"]);
    Route::put("/generoHTTP/{id}", [GeneroController::class, "updateHTTP"])->where("id", "[0-9]+");

});
