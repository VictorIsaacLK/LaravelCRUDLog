<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use App\Models\Videojuegos\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;



class PersonaController extends Controller
{
    // public function create(Request $request)
    // {
    //     $validacion = Validator::Make(
    //         $request->all(),[
    //             "nombre"        => "required|max:30",
    //             "ap_paterno"    => "required|max:30",
    //             "ap_materno"    => "max:30|string|nullable",
    //             "edad"          => "required|integer|min:1|max:120"
    //         ]
    //         );
    //         if($validacion->fails())
    //         {
    //             return response()->json([
    //                 "status"    => 400,
    //                 "msg"       => "No se cumplieron las validaciones",
    //                 "error"     => $validacion->errors(),
    //                 "data"      => null
    //             ], 400);
    //         }
 
            
    //         $persona = new Persona();
    //         $persona->nombre        = $request->nombre;
    //         $persona->ap_paterno    = $request->ap_paterno;
    //         $persona->ap_materno    = $request->ap_materno;
    //         $persona->edad          = $request->edad;

    //         if($persona->save()){
    //             return response()->json([
    //                 "status"        => 201,
    //                 "msg"           => "Se insertaron datos de manera satisfactoria",
    //                 "error"         => null,
    //                 "data"          => $persona
    //             ], 201);
    //         }
            
    // }

    public function create(Request $request)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "ap_paterno"    => "required|max:30",
                "ap_materno"    => "max:30|string|nullable",
                "edad"          => "required|integer|min:1|max:120"
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

            $persona = new Persona();
            $persona->nombre        = $request->nombre;
            $persona->ap_paterno    = $request->ap_paterno;
            $persona->ap_materno    = $request->ap_materno;
            $persona->edad          = $request->edad;

            if($persona->save()){
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Se insertaron datos de manera satisfactoria",
                    "error"         => null,
                    "data"          => $persona
                ], 201);
            }

    }

    // public function create(Request $request)
    // {
    //     $validacion = Validator::Make(
    //         $request->all(),[
    //             "nombre"        => "required|max:30",
    //             "ap_paterno"    => "required|max:30",
    //             "ap_materno"    => "max:30|string|nullable",
    //             "edad"          => "required|integer|min:1|max:120"
    //         ]
    //         );
    //         if($validacion->fails())
    //         {
    //             return response()->json([
    //                 "status"    => 400,
    //                 "msg"       => "No se cumplieron las validaciones",
    //                 "error"     => $validacion->errors(),
    //                 "data"      => null
    //             ], 400);
    //         }
 
    //         $response = Http::post('http://192.168.252.127:8000/api/httpEx/persona', [
    //             'nombre'        => $request->nombre,
    //             'ap_paterno'    => $request->ap_paterno,
    //             'ap_materno'    => $request->ap_materno,
    //             'edad'          => $request->edad
    //         ]);
    //         $response = Http::post('http://192.168.252.128:8000/api/httpEx/persona', [
    //             'nombre'        => $request->nombre,
    //             'ap_paterno'    => $request->ap_paterno,
    //             'ap_materno'    => $request->ap_materno,
    //             'edad'          => $request->edad
    //         ]);

    //         if($response->successful()){
    //             return response()->json(["buenos dias tu"=>$response]);
    //         }
    //     return response()->json(["fallo we"],400);
    // }




    public function update(Request $request, int $id)
    {
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "ap_paterno"    => "required|max:30",
                "ap_materno"    => "max:30|string|nullable",
                "edad"          => "required|integer|min:1|max:120"
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

            $persona = Persona::find($id);
            $persona->nombre        = $request->nombre;
            $persona->ap_paterno    = $request->ap_paterno;
            $persona->ap_materno    = $request->ap_materno;
            $persona->edad          = $request->edad;

            if($persona){
                if($persona->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Los datos se actualizaron de manera adecuada",
                        "error"         => null,
                        "data"          => $persona
                    ], 201);
                }
            } else {
                return response()->json([
                    "status"    =>400,
                    "msg"       =>"Datos no validados",
                    "error"     =>"La persona con el id:{$id} no fue encontrada",
                    "data"      =>$request->all()
                ], 400);
            }
    }

    public function index(){
        // $persona = Persona::select('carros.marca', 'personas.nombre')
        //                             ->join('carros', 'carros.persona_id', '=', 'personas.id')
        //                             ->get();

        // $persona = Carro::with('persona')
        //                     ->get();

        // $persona = Persona::find(2);
        // $persona->Carros;

        return response()->json([
            "status"=>200,
            "msg"=>"Informacion localizada",
            "error"=>null,
            // "data"=>Persona::all()
            "data"=>Persona::where('status', true)->get()
        ],200);
    }



    public function delete(Request $request, int $id){
        $persona = Persona::find($id);
        if($persona){
            $persona->status=false;
            $persona->save();
            return response()->json([
                "status" => 200,
                "msg" => "Informacion eliminada",
                "error" => null,
                "data"=>$persona
            ]);
        }
    }


    ////////////////////////////////////////////////////

    public function createHTTP(Request $request)
    {
        $ipteam = 'http://25.7.29.88:8000';
        $validacion = Validator::Make(
            $request->all(),[
                "nombre"        => "required|max:30",
                "ap_paterno"    => "required|max:30",
                "ap_materno"    => "max:30|string|nullable",
                "edad"          => "required|integer|min:1|max:120"
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
 
            $response = Http::post("$ipteam/api/httpEx/persona", [
                'nombre'        => $request->nombre,
                'ap_paterno'    => $request->ap_paterno,
                'ap_materno'    => $request->ap_materno,
                'edad'          => $request->edad
            ]);

            if($response->successful()){
                $persona = new Persona();
                $persona->nombre        = $request->nombre;
                $persona->ap_paterno    = $request->ap_paterno;
                $persona->ap_materno    = $request->ap_materno;
                $persona->edad          = $request->edad;

                if($persona->save()){
                    return response()->json([
                        "status"        => 201,
                        "msg"           => "Se insertaron datos de manera satisfactoria",
                        "error"         => null,
                        "data"          => $persona
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
                "ap_paterno"    => "required|max:30",
                "ap_materno"    => "max:30|string|nullable",
                "edad"          => "required|integer|min:1|max:120"
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


            $response = Http::put("$ipteam/api/httpEx/persona/{$id}", [
                'nombre'        => $request->nombre,
                'ap_paterno'    => $request->ap_paterno,
                'ap_materno'    => $request->ap_materno,
                'edad'          => $request->edad
            ]);

            if($response->successful()){
                $persona = Persona::find($id);
                $persona->nombre        = $request->nombre;
                $persona->ap_paterno    = $request->ap_paterno;
                $persona->ap_materno    = $request->ap_materno;
                $persona->edad          = $request->edad;

                if($persona){
                    if($persona->save()){
                        return response()->json([
                            "status"        => 201,
                            "msg"           => "Los datos se actualizaron de manera adecuada",
                            "error"         => null,
                            "data"          => $persona
                        ], 201);
                    }
                } else {
                    return response()->json([
                        "status"    =>400,
                        "msg"       =>"Datos no validados",
                        "error"     =>"La persona con el id:{$id} no fue encontrada",
                        "data"      =>$request->all()
                    ], 400);
                }
            }
    }

    public function deleteHTTP(int $id){
        $ipteam = 'http://25.7.29.88:8000';
        $response = Http::delete("$ipteam/api/httpEx/persona/{$id}", []);
        if($response->successful()){
            $persona = Persona::find($id);
            if($persona){
                $persona->status=false;
                $persona->save();
                return response()->json([
                    "status" => 200,
                    "msg" => "Informacion eliminada",
                    "error" => null,
                    "data"=>$persona
                ]);
            }
        }
    }
}
