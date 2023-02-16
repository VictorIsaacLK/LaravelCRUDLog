<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Videojuegos\Consola;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ConsolaController extends Controller
{
    public function create(Request $request)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "company"       => "required|max:30",
                "precio"        => "required|numeric|min:1",
                "tipo"          => "required|max:30",
                "controles"     => "required|integer"
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

            $consola = new Consola();
            $consola->nombre    = $request->nombre;
            $consola->company   = $request->company;
            $consola->precio    = $request->precio;
            $consola->tipo      = $request->tipo;
            $consola->controles = $request->controles;

            if($consola->save()){
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Se insertaron datos de manera satisfactoria",
                    "error"         => null,
                    "data"          => $consola
                ], 201);
            }
    }

    public function update(Request $request, int $id)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "company"       => "required|max:30",
                "precio"        => "required|numeric|min:1",
                "tipo"          => "required|max:30",
                "controles"     => "required|integer"
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

            $consola = Consola::find($id);
            $consola->nombre    = $request->nombre;
            $consola->company   = $request->company;
            $consola->precio    = $request->precio;
            $consola->tipo      = $request->tipo;
            $consola->controles = $request->controles;

            if($consola){
                if($consola->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Los datos se actualizaron de manera adecuada",
                        "error"         => null,
                        "data"          => $consola
                    ], 201);
                }
            } else {
                return response()->json([
                    "status"    =>400,
                    "msg"       =>"Datos no validados",
                    "error"     =>"La consola con el id:{$id} no fue encontrada",
                    "data"      =>$request->all()
                ], 400);
            }
    }


    public function index(){
        return response()->json([
            "status"=>200,
            "msg"=>"Informacion localizada",
            "error"=>null,
            // "data"=>Consola::all()
            "data"=>Consola::where('status', true)->get()
        ],200);
    }

    public function delete(Request $request, int $id){
        $consola = Consola::find($id);
        if($consola){
            $consola->status=false;
            $consola->save();
            return response()->json([
                "status" => 200,
                "msg" => "Informacion eliminada",
                "error" => null,
                "data"=>$consola
            ]);
        }
    }
    


    /////////////////////////////////////

    public function createHTTP(Request $request)
    {
        $ipteam = 'http://25.7.29.88:8000';
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "company"       => "required|max:30",
                "precio"        => "required|numeric|min:1",
                "tipo"          => "required|max:30",
                "controles"     => "required|integer"
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

            $response = Http::post("$ipteam/api/httpEx/consola", [
                'nombre'        => $request->nombre,
                'company'       => $request->company,
                'precio'        => $request->precio,
                'tipo'          => $request->tipo,
                'controles'     => $request->controles
            ]);

            if($response->successful()){
                $consola = new Consola();
                $consola->nombre    = $request->nombre;
                $consola->company   = $request->company;
                $consola->precio    = $request->precio;
                $consola->tipo      = $request->tipo;
                $consola->controles = $request->controles;

                if($consola->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Se insertaron datos de manera satisfactoria",
                        "error"         => null,
                        "data"          => $consola
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
                "company"       => "required|max:30",
                "precio"        => "required|numeric|min:1",
                "tipo"          => "required|max:30",
                "controles"     => "required|integer"
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

            $response = Http::put("$ipteam/api/httpEx/consola/{$id}", [
                'nombre'        => $request->nombre,
                'company'       => $request->company,
                'precio'        => $request->precio,
                'tipo'          => $request->tipo,
                'controles'     => $request->controles
            ]);

            if($response->successful()){
                $consola = Consola::find($id);
                $consola->nombre    = $request->nombre;
                $consola->company   = $request->company;
                $consola->precio    = $request->precio;
                $consola->tipo      = $request->tipo;
                $consola->controles = $request->controles;

                if($consola){
                    if($consola->save()){
                        return response()->json([
                            "status"        => 201,
                            "msg"           => "Los datos se actualizaron de manera adecuada",
                            "error"         => null,
                            "data"          => $consola
                        ], 201);
                    }
                } else {
                    return response()->json([
                        "status"    =>400,
                        "msg"       =>"Datos no validados",
                        "error"     =>"La consola con el id:{$id} no fue encontrada",
                        "data"      =>$request->all()
                    ], 400);
                }
            }
    }

    public function deleteHTTP(Request $request, int $id){
        $ipteam = 'http://25.7.29.88:8000';
        $response = Http::delete("$ipteam/api/httpEx/consola/{$id}", []);


        if($response->successful()){
            $consola = Consola::find($id);
            if($consola){
                $consola->status=false;
                $consola->save();
                return response()->json([
                    "status" => 200,
                    "msg" => "Informacion eliminada",
                    "error" => null,
                    "data"=>$consola
                ]);
            }
        }
        
    }

}
