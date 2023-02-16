<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use App\Models\Videojuegos\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class RolController extends Controller
{
    public function addRol(Request $request){
        $validacion = Validator::Make(
            $request->all(), [
                'nombre'      => "required|string|max:255"
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

        // $usuario = new User();
        // $usuario->name      =   $request->name;
        // $usuario->email     =   $request->email;
        // $usuario->password  =   $request->password;


        $rol = new Rol();
        $rol->nombre = $request->nombre;
        
        if($rol->save())
        {
            return response()->json([
                "status"        => 201,
                "msg"           => "Se insertaron datos de manera satisfactoria",
                "error"         => null,
                "data"          => $rol
            ], 201);
        }


    }
}