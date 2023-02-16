<?php

namespace Database\Seeders;

use App\Models\Videojuegos\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::insert([
            ['nombre'   => 'admin'],
            ['nombre'   => 'user'],
            ['nombre'   => 'guest']
        ]);
    }
}
