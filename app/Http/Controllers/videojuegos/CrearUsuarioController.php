<?php

namespace App\Http\Controllers\videojuegos;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessEmails;
use App\Mail\SendConfirmation;
use App\Models\User;
use \stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\CssSelector\Parser\Token;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Videojuegos\Code;
use Illuminate\Support\Facades\URL;



class CrearUsuarioController extends Controller
{
    public function crearUsuario(Request $request){
        $validacion = Validator::Make(
            $request->all(), [
                'name'      => "required|string|max:255",
                'email'     => "required|string|unique:users|email",
                'password'  => "required|string|min:4",
                'role_id'   => "required|integer"
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

        $usuario = new User();
        $usuario->name      =   $request->name;
        $usuario->email     =   $request->email;
        $usuario->password  =   bcrypt($request->password);
        $usuario->role_id   =   $request->role_id;
        $usuario->save();

        // $usuario = User::create([
        //     'name'      => $request->name,
        //     'email'     => $request->email,
        //     'password'  => Hash::make($request->password),
        //     'role_id'   => $request->role_id
        // ]);

        $url = URL::temporarySignedRoute(
            'hola', now()->addMinutes(30), ['url' => $usuario->id]
        );

        //Mail::to($request->email)->send(new SendMail($usuario, $url));
        ProcessEmails::dispatch($usuario, $url)->onQueue('ProcessEmails')->onConnection('database')->delay(now()->addSeconds(20));

        // $token = $usuario->createToken('auth_token')->plainTextToken;
        // $usuario->remember_token = $token;                                  //si vas a hacerlo de la otra manera, borra esta linea
        //Y PEGA LA LINEA DEL TOKEN EN EL LOGEO


        if($usuario->save()){
            // $token = $request->user()->createToken($request->token_name);
            return response()->json([
                "status"        => 201,
                "msg"           => "Se ha registrado de manera satisfactoria",
                "error"         => null,
                "data"          => $usuario
            ], 201);
        }else{
            return response()->json([
                "msg"   =>  "Existe un error al registrar el usuario, por favor verifique que sea la informacion adecuada"
            ]);
        }
    }

    public function sendMenssage(Request $request){
        $validacion = Validator::Make(
            $request->all(), [
                'email'     => "required|string|email",
                'numero'    => "required|integer"
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

        $codigoConfirmacion = rand(10000, 99999);

         $user = DB::table('users')->where('email', $request->email)->exists();
         if(!$user){
            return response()->json([
                "status"        => 403,
                "advertisment"  => "Este correo esta mal escrito o no registrado"
            ], 403);
         }else{

            $persona = DB::table('users')->where('email', $request->email)->first();
            $persona2 = User::find($persona->id);
            $code = DB::table('codes')->where('persona_id', $persona2->id)->first();
            //dd($code);
            

            $ProvideCode = Code::select('codes.code')
                                        ->join('users', 'users.id', '=', 'codes.persona_id')
                                        ->get();

            if(!$code){
                
                $response = Http::post('https://rest.nexmo.com/sms/json', [
                    'from'              => "Proyecto X",
                    'text'              => "Tu codigo de activacion de ProyectoX es ".$codigoConfirmacion."\n\n",
                    'to'                => "52".$request->numero,
                    'api_key'           => "ff1faa5e",
                    'api_secret'        => "VtJTzGyXvaCl79Kh",
                ]);


    
                $usuario = DB::table('users')->where('email', $request->email)->first();
                $usuario2 = User::find($usuario->id);
                
                $url = URL::temporarySignedRoute(
                    'codigoC', now()->addMinutes(30), ['url' => $usuario2->id]
                );  
        
                Mail::to($request->email)->send(new SendConfirmation($usuario2, $url));
    
                if($response->successful()){
                    $codigo = new Code();
                    $codigo->code = $codigoConfirmacion;
                    $codigo->persona_id = $usuario->id;
                    $codigo->save();

                    return response()->json([
                        "status"    => $response->status(),
                        "msg"      => "El mensaje fue enviado de manera adecuada"
                    ], 200);
                } else {
                    return response()->json([
                        "error"     => "El mensage ha fallado con el estatus: ".$response->getStatus()
                    ]);
                }
            }else{
                return response()->json([
                    'msg'                   => 'Esta accion no esta disponible, puesto que este codigo ya ha sido provisto',
                    'codigo de activacion'  => $ProvideCode
                ], 403);
            }

            
         }

    }

    public function verifyAccount(Request $request){
        $validacion = Validator::Make(
            $request->all(), [
                'email'     => "required|email",
                'code'      => "required|integer"
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

        $user = DB::table('users')->where('email', $request->email)->first();
        $usuario = Code::select('codes.persona_id')
                                        ->join('users', 'users.id', '=', 'codes.persona_id')
                                        ->get();
        $ProvideCode = Code::select('codes.code')
                                        ->join('users', 'users.id', '=', 'codes.persona_id')
                                        ->get();


        $code = DB::table('codes')->where('code', $request->code)->first();
        //dd($code);
        $user2 = User::find($code->persona_id);
        //dd($user2);


        if($user && $code){
            if($user2){
                $user2->status=true;
                $user2->save();
                return response()->json([
                    "status" => 200,
                    'msg'     => 'Has activado con exito tu cuenta',
                    "error" => null,
                    "data"=>$user2
                ]);
            }
        }


    }
    


    public function logearUsuario(Request $request){
        $validacion = Validator::Make(
            $request->all(), [
                'email'     => "required|string|email",
                'password'  => "required|string|min:4",
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

        $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
                $token= $user->createToken("auth_token")->plainTextToken;
                return response()->json(["Usuario Ingresado"=>[
                    "Usuario"=>$request->email,
                    "Token"=>$token
                    ]],200);
    }



    public function logout(Request $request){

        $request->user()->tokens()->delete();
        //auth('sanctum')->user()-currentAccessToken()->delete();
        return response()->json([
            "status"        => 200,
            "msg"           => "Has salido de la sesion de manera adecuada"
        ], 200);
    }

    public function crearUsuarioHTTP(Request $request){
        $ipteam = 'http://25.7.29.88:8000';
        $validacion = Validator::Make(
            $request->all(), [
                'name'      => "required|string|max:255",
                'email'     => "required|string|unique:users|email",
                'password'  => "required|string|min:4",
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

        $response = Http::post("$ipteam/api/httpEx/registro", [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password
        ]);


        if($response->successful()){
            $usuario = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ]);
    
            // $token = $usuario->createToken('auth_token')->plainTextToken;
            // $usuario->remember_token = $token;                                  //si vas a hacerlo de la otra manera, borra esta linea
            //Y PEGA LA LINEA DEL TOKEN EN EL LOGEO
    
    
            if($usuario->save()){
                // $token = $request->user()->createToken($request->token_name);
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Se insertaron datos de manera satisfactoria",
                    "error"         => null,
                    "data"          => $usuario
                ], 201);
            }
        }
    }

    // public function logearUsuarioHTTP(Request $request){
    //     $ipteam = 'http://25.7.29.88:8000';
    //     $validacion = Validator::Make(
    //         $request->all(), [
    //             'email'     => "required|string|email",
    //             'password'  => "required|string|min:4",
    //         ]
    //     );
    //     if($validacion->fails())
    //     {
    //         return response()->json([
    //             "status"    => 400,
    //             "msg"       => "No se cumplieron las validaciones",
    //             "error"     => $validacion->errors(),
    //             "data"      => null
    //         ], 400);
    //     }

    //     $response = Http::post("$ipteam/api/httpEx/iniciarSesion", [
    //         'email'         => $request->name,
    //         'password'      => $request->email
    //     ]);

    //     if($response->successful()){
    //         $user = User::where('email', $request->email)->first();
    //         if (! $user || ! Hash::check($request->password, $user->password)) {
    //             throw ValidationException::withMessages([
    //                 'email' => ['The provided credentials are incorrect.'],
    //             ]);
    //         }
            
    //         $token= $user->createToken("auth_token")->plainTextToken;
    //         return response()->json(["Usuario Ingresado"=>[
    //             "Usuario"=>$request->email,
    //             "Token"=>$token
    //             ]],200);
    //     }
    // }
}
