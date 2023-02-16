<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use App\Models\Videojuegos\Juego;
use App\Models\Videojuegos\JuegoPersona;
use App\Models\Videojuegos\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class RelacionController extends Controller
{

    public function juegosPersonas(Request $request){

        $validacion = Validator::Make(
            $request->all(),[
                "persona_id"     => "required|integer",
                "juego_id"      => "required|integer"
            ]
            );
            if($validacion->fails())
            {
                return response()->json([
                    "status"    => 400,
                    "msg"       => "No se cumplieron las validaciones",
                    "error"     => $validacion->errors(),
                    "data"      => null
                ], 400);
            }

            $persona    = Persona::find($request->persona_id);
            $juego      = Juego::find($request->juego_id);
            $juegopersona = new JuegoPersona();
            $juegopersona->persona_id   = $request->persona_id;
            $juegopersona->juego_id     = $request->juego_id;

            // $juegopersona->juegospersonas()->sync($request->persona_id);
            // $juego->sync($request->juegoid);


            // $persona->juegos()->save($juego);
            // $juego->personas()->save($persona);

            
            if($juegopersona->save()){
                $juegopersona->refresh();
                $juegopersona->juegos_personas;
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Se insertaron datos de manera satisfactoria",
                    "error"         => null,
                    "data"          => $juegopersona
                ], 201);
            }
            else {
                return response()->json([
                    "status"    =>400,
                    "msg"       =>"Datos no validados",
                    "error"     =>$request->errors(),
                    "data"      =>$request->all()
                ], 400);
            }

            //relacion
            // $persona->Carros()->save($carro);
            // if($persona->save()){
            //     $persona->refresh();
            //     $persona->Carros;
            //     return response()->json([
            //         "status"        => 201,
            //         "msg"           => "Se insertaron datos de manera satisfactoria",
            //         "error"         => null,
            //         "data"          => $carro
            //     ], 201);
            // }

    }
}
