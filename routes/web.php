<?php

use App\Http\Controllers\FullStack\GeneroController;
use App\Http\Controllers\FullStack\JuegoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('/FullStack')->group(function () {
    Route::get("/addGen", [GeneroController::class, "index"]);
    Route::post("/addGen", [GeneroController::class, "addGen"]);
    Route::get("/tgeneros", [GeneroController::class, "tablagen"]);
    Route::get("/genero/{id}", [GeneroController::class, "updateG"])->where("id", "[0-9]+");
    Route::post("/genero/{id}", [GeneroController::class, "editGen"])->where("id", "[0-9]+");

    Route::get("/dgenero/{id}", [GeneroController::class, "deleteGen"])->where("id", "[0-9]+");

    Route::get("/addjuego", [JuegoController::class, "index"]);
    Route::post("/addjuego", [JuegoController::class, "create"]);
    Route::get("/tjuegos", [JuegoController::class, "tablaj"]);
    Route::get("/juego/{id}", [JuegoController::class, "updateJ"])->where("id", "[0-9]+");
    Route::post("/juego/{id}", [JuegoController::class, "editJue"])->where("id", "[0-9]+");

    Route::get("/djuego/{id}", [JuegoController::class, "deleteJ"])->where("id", "[0-9]+");
    Route::get("/agentoju/{id}", [JuegoController::class, "agggeneros"])->where("id", "[0-9]+");
    Route::post("/agentoju/{id}", [JuegoController::class, "añadirgen"])->where("id", "[0-9]+");

    Route::get("/tablarel/{id}", [JuegoController::class, "muestrarel"])->where("id", "[0-9]+");
});
