<?php

namespace App\Models\Videojuegos;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;
    protected $table = 'codes';

    public function usuarios()
    {
        return $this->belongsTo(User::class);
    }
}
