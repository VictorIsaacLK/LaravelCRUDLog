<?php

namespace App\Models\Videojuegos;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Contracts\Auth;
use App\Models\Videojuegos\Persona as Persona2;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Persona extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personas';
    
    public function juegos()
    {
        return $this->belongsToMany(Juego::class, 'juegos_personas', 'id', 'juego_id');
    }

    public function consolas()
    {
        return $this->belongsToMany(Consola::class, 'consolas_personas');
    }

    use HasApiTokens, HasFactory, Notifiable;    
}




