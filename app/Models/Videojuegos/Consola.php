<?php

namespace App\Models\Videojuegos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consola extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consolas';

    /**
     * Get the comments for the blog post.
     */
    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'consolas_personas');
    }
}
