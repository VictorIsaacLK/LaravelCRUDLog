<?php

namespace App\Http\Controllers\FullStack;

use App\Http\Controllers\Controller;
use App\Models\Videojuegos\Genero;
use App\Models\Videojuegos\GeneroJuego;
use App\Models\Videojuegos\Juego;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function index(){
        return view('fullstack.crearjuego');
    }

    public function create(Request $request){
        $request->validate([    
            'nombre'        => 'required|max:30',
            'costo'         => 'required|regex:/^\d*(\.\d{2})?$/|min:1',
            'jugadores'     => 'required|integer',
            'clasificacion' => 'required|max:30|string',
            'codigo'        => 'required|max:7|string'
        ]);

        $juego = new Juego();
        $juego->nombre          = $request->nombre;
        $juego->costo           = $request->costo;
        $juego->jugadores       = $request->jugadores;
        $juego->clasificacion   = $request->clasificacion;
        $juego->codigo          = $request->codigo;
        $juego->save();

        if ($juego->save()) {
            return redirect('/FullStack/tjuegos');
        }

    }

    public function tablaj(){
        $juegos = Juego::all();
        return view('fullstack.tablajuegos', compact('juegos'));
    }

    public function updateJ(Request $request, $id)
    {
        $juego = Juego::find($id);
        return view('fullstack.editarjuego', compact(array('juego', 'id')));
    }

    public function editJue(Request $request, $id)
    {
        $request->validate([
            'nombre'        => 'required|max:30',
            'costo'         => 'required|regex:/^\d*(\.\d{2})?$/|min:1',
            'jugadores'     => 'required|integer',
            'clasificacion' => 'required|max:30|string',
            'codigo'        => 'required|max:7|string'
        ]);
        $juego = Juego::find($id);
        $juego->nombre          = $request->nombre;
        $juego->costo           = $request->costo;
        $juego->jugadores       = $request->jugadores;
        $juego->clasificacion   = $request->clasificacion;
        $juego->codigo          = $request->codigo;
        $juego->save();


        if ($juego->save()){
            return redirect('/FullStack/tjuegos');
        }
    }

    public function deleteJ(Request $request, $id)
    {
        $juego = Juego::find($id);
        $juego->delete();

        if ($juego){
            return redirect('/FullStack/tjuegos');
        }
    }

    public function agggeneros(Request $request, $id){
        $juego = Juego::find($id);
        $generos = Genero::all();
        return view('fullstack.addgenerosajuegos', compact(array('juego', 'generos', 'id')));
    }

    public function añadirgen(Request $request, $id){
        $juego = Juego::find($id);
        $generos = Genero::find($request->genero);
        $generojuego = new GeneroJuego();
        $generojuego->juego_id = $juego->id;
        $generojuego->genero_id = $generos->id;
        $generojuego->save();
        return redirect('/FullStack/tjuegos');
    }

    public function muestrarel(Request $request, $id){
        $generojuego = GeneroJuego::where('juego_id', $id);
        dd($generojuego);
        $generos = array();
        foreach($generojuego as $generojuego){
            $generos = $generojuego;
        }
        dd($generos);
        $juego = Juego::find($generojuego->juego_id);
        $genero = Genero::find($generojuego->genero_id);
        return view('fullstack.tablarelacionjuegos', compact(array('generojuegos','id', 'genero', 'juego')));
    }
}
