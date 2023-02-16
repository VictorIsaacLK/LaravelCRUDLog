<?php

namespace App\Models\Videojuegos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'juegos';

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'juegos_personas', 'id', 'persona_id');
    }

    public function generos()
    {
        return $this->belongsToMany(Genero::class, 'generos_juegos');
    }
}
