<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Videojuegos\Juego;
use App\Models\Videojuegos\JuegoPersona;
use App\Models\Videojuegos\Persona;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class JuegoController extends Controller
{
    public function create(Request $request)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "costo"         => "required|numeric|min:1",
                "jugadores"     => "required|max:30",
                "clasificacion" => "max:30|string",
                "codigo"        => "max:7|string"
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

            $juego = new Juego();
            $juego->nombre          = $request->nombre;
            $juego->costo           = $request->costo;
            $juego->jugadores       = $request->jugadores;
            $juego->clasificacion   = $request->clasificacion;
            $juego->codigo          = $request->codigo;

            if($juego->save()){
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Se insertaron datos de manera satisfactoria",
                    "error"         => null,
                    "data"          => $juego
                ], 201);
            }
    }

    public function update(Request $request, int $id)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "costo"         => "required|numeric|min:1",
                "jugadores"     => "required|max:30",
                "clasificacion" => "max:30|string",
                "codigo"        => "max:7|string"
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

            $juego = Juego::find($id);
            $juego->nombre          = $request->nombre;
            $juego->costo           = $request->costo;
            $juego->jugadores       = $request->jugadores;
            $juego->clasificacion   = $request->clasificacion;
            $juego->codigo           = $request->codigo;

            if($juego){
                if($juego->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Los datos se actualizaron de manera adecuada",
                        "error"         => null,
                        "data"          => $juego
                    ], 201);
                }
            } else {
                return response()->json([
                    "status"    =>400,
                    "msg"       =>"Datos no validados",
                    "error"     =>"El juego con el id:{$id} no fue encontrado",
                    "data"      =>$request->all()
                ], 400);
            }
    }


    public function index(){

        return response()->json([
            "status"=>200,
            "msg"=>"Informacion localizada",
            "error"=>null,
            // "data"=>Persona::all()
            "data"=>Juego::where('status', true)->get()
        ],200);
    }

    public function delete(Request $request, int $id){
        $juego = Juego::find($id);
        if($juego){
            $juego->status=false;
            $juego->save();
            return response()->json([
                "status" => 200,
                "msg" => "Informacion eliminada",
                "error" => null,
                "data"=>$juego
            ]);
        }
    }


///////////////////////////////////////////////////

    public function createHTTP(Request $request)
    {
        $ipteam = 'http://25.7.29.88:8000';
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "costo"         => "required|numeric|min:1",
                "jugadores"     => "required|max:30",
                "clasificacion" => "max:30|string",
                "codigo"        => "max:7|string"
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

            $response = Http::post("$ipteam/api/httpEx/juego", [
                'nombre'            => $request->nombre,
                'costo'             => $request->costo,
                'jugadores'         => $request->jugadores,
                'clasificacion'     => $request->clasificacion,
                'codigo'            =>$request->codigo
            ]);


            if($response->successful()){

                $juego = new Juego();
                $juego->nombre          = $request->nombre;
                $juego->costo           = $request->costo;
                $juego->jugadores       = $request->jugadores;
                $juego->clasificacion   = $request->clasificacion;
                $juego->codigo           = $request->codigo;

                if($juego->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Se insertaron datos de manera satisfactoria",
                        "error"         => null,
                        "data"          => $juego
                    ], 201);
                }
            }
    }

    public function updateHTTP(Request $request, int $id)
    {
        $ipteam = 'http://25.7.29.88:8000';
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "costo"         => "required|numeric|min:1",
                "jugadores"     => "required|max:30",
                "clasificacion" => "max:30|string",
                "codigo"        => "max:7|string"
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

            $response = Http::put("$ipteam/api/httpEx/juego/{$id}", [
                'nombre'            => $request->nombre,
                'costo'             => $request->costo,
                'jugadores'         => $request->jugadores,
                'clasificacion'     => $request->clasificacion,
                'codigo'            =>$request->codigo
            ]);

            if($response->successful()){

                $juego = Juego::find($id);
                $juego->nombre          = $request->nombre;
                $juego->costo           = $request->costo;
                $juego->jugadores       = $request->jugadores;
                $juego->clasificacion   = $request->clasificacion;
                $juego->codigo           = $request->codigo;

                if($juego){
                    if($juego->save()){
                        return response()->json([
                            "status"        => 201,
                            "msg"           => "Los datos se actualizaron de manera adecuada",
                            "error"         => null,
                            "data"          => $juego
                        ], 201);
                    }
                } else {
                    return response()->json([
                        "status"    =>400,
                        "msg"       =>"Datos no validados",
                        "error"     =>"El juego con el id:{$id} no fue encontrado",
                        "data"      =>$request->all()
                    ], 400);
                }
            }
    }

    public function deleteHTTP(Request $request, int $id){
        $ipteam = 'http://25.7.29.88:8000';
        $response = Http::delete("$ipteam/api/httpEx/persona/{$id}", []);
        

        if($response->successful()){
            $juego = Juego::find($id);
            if($juego){
                $juego->status=false;
                $juego->save();
                return response()->json([
                    "status" => 200,
                    "msg" => "Informacion eliminada",
                    "error" => null,
                    "data"=>$juego
                ]);
            }
        }
    }




}
