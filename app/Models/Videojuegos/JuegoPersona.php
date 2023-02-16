<?php

namespace App\Models\Videojuegos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class JuegoPersona extends Pivot
{
    use HasFactory;
    protected $table = 'juegos_personas';


    public function juegospersonas()
    {
        return $this->belongsToMany(Persona::class, 'juegos_personas', 'id', 'persona_id')
                    ->belongsToMany(Juego::class, 'juegos_personas', 'id', 'juego_id');
    }


}
