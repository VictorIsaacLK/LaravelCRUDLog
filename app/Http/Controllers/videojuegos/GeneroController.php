<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Videojuegos\Genero;
use App\Models\Videojuegos\Juego;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class GeneroController extends Controller
{
    public function create(Request $request)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "descripcion"   => "required|max:80"
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

            $genero = new Genero();
            $genero->nombre         = $request->nombre;
            $genero->descripcion    = $request->descripcion;

            if($genero->save()){
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Se insertaron datos de manera satisfactoria",
                    "error"         => null,
                    "data"          => $genero
                ], 201);
            }
    }

    public function update(Request $request, int $id)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "descripcion"   => "required|max:80"
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

            $genero = Genero::find($id);
            $genero->nombre         = $request->nombre;
            $genero->descripcion    = $request->descripcion;

            if($genero){
                if($genero->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Los datos se actualizaron de manera adecuada",
                        "error"         => null,
                        "data"          => $genero
                    ], 201);
                }
            } else {
                return response()->json([
                    "status"    =>400,
                    "msg"       =>"Datos no validados",
                    "error"     =>"El genero con el id:{$id} no fue encontrado",
                    "data"      =>$request->all()
                ], 400);
            }
    }


    public function index(){

        return response()->json([
            "status"=>200,
            "msg"=>"Informacion localizada",
            "error"=>null,
            "data"=>Genero::all()
            // "data"=>Genero::where('status', true)->get()
        ],200);
    }

    //////////////////////////////////////////////////////////////////////////////////

    public function createHTTP(Request $request)
    {
        $ipteam = 'http://25.7.29.88:8000';
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "descripcion"   => "required|max:80"
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


            $response = Http::post("$ipteam/api/httpEx/genero", [
                'nombre'        => $request->nombre,
                'descripcion'    => $request->descripcion
            ]);

            if($response->successful()){
                $genero = new Genero();
                $genero->nombre         = $request->nombre;
                $genero->descripcion    = $request->descripcion;

                if($genero->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Se insertaron datos de manera satisfactoria",
                        "error"         => null,
                        "data"          => $genero
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
                "descripcion"   => "required|max:80"
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

            $response = Http::put("$ipteam/api/httpEx/genero/{$id}", [
                'nombre'        => $request->nombre,
                'descripcion'    => $request->descripcion
            ]);

            if($response->successful()){
                $genero = Genero::find($id);
                $genero->nombre         = $request->nombre;
                $genero->descripcion    = $request->descripcion;

                if($genero){
                    if($genero->save()){
                        return response()->json([
                            "status"        => 201,
                            "msg"           => "Los datos se actualizaron de manera adecuada",
                            "error"         => null,
                            "data"          => $genero
                        ], 201);
                    }
                } else {
                    return response()->json([
                        "status"    =>400,
                        "msg"       =>"Datos no validados",
                        "error"     =>"El genero con el id:{$id} no fue encontrado",
                        "data"      =>$request->all()
                    ], 400);
                }
            }
    }

    // public function delete(Request $request, int $id){
    //     $genero = Genero::find($id);
    //     if($genero){
    //         $genero->status=false;
    //         $genero->save();
    //         return response()->json([
    //             "status" => 200,
    //             "msg" => "Informacion eliminada",
    //             "error" => null,
    //             "data"=>$genero
    //         ]);
    //     }
    // }
}
