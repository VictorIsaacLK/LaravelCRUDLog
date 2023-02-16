<?php

namespace App\Models\Videojuegos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'generos';

    public function juegos()
    {
        return $this->belongsToMany(Juego::class, 'generos_juegos');
    }
}
