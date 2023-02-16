<?php

namespace App\Http\Controllers\FullStack;

use App\Http\Controllers\Controller;
use App\Models\Videojuegos\Genero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneroController extends Controller
{
    public function index(){
        return view('fullstack.crearGenero');        
    }

    public function addGen(Request $request)
    {
        // dd($request);
        $request->validate([
            'nombre'        => 'required|max:30|unique:generos',
            'descripcion'   => 'required|max:200'
        ]);

        $genero = new Genero();
        $genero->nombre         = $request->nombre;
        $genero->descripcion    = $request->descripcion;
        $genero->save();

        if($genero->save()){
            return redirect('/FullStack/tgeneros');
        }

    }

    public function tablagen(){
        $generos = Genero::all();
        return view('fullstack.tablageneros', compact('generos'));
    }

    public function updateG(Request $request, $id)
    {
        $genero = Genero::find($id);
        return view('fullstack.editargen', compact(array('genero', 'id')));
    }
    
    public function editGen(Request $request, $id)
    {
        $request->validate([
            'nombre'        => 'required|max:30',
            'descripcion'   => 'required|max:200'
        ]);
        $genero = Genero::find($id);
        $genero->nombre = $request->nombre;
        $genero->descripcion = $request->descripcion;
        $genero->save();

        if ($genero->save()){
            return redirect('/FullStack/tgeneros');
        }
    }

    public function deleteGen(Request $request, $id)
    {
        $genero = Genero::find($id);
        $genero->delete();

        if ($genero){
            return redirect('/FullStack/tgeneros');
        }
    }
}
