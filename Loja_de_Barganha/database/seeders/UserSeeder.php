<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administradores
        User::create([
            'name' => 'Admin Loja',
            'email' => 'admin@barganha.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Ana Colecionadora',
            'email' => 'ana@email.com',
            'password' => bcrypt('senha123'),
            'is_admin' => false,
        ]);

        // Usuários normais
        User::create([
            'name' => 'Carlos Rockeiro',
            'email' => 'carlos@rock.com',
            'password' => bcrypt('rock123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Fernanda Games',
            'email' => 'feh@retro.com',
            'password' => bcrypt('games123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Ricardo Otaku',
            'email' => 'ricardo@anime.com',
            'password' => bcrypt('anime123'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Patrícia MPB',
            'email' => 'patricia@mpb.com',
            'password' => bcrypt('mpb123'),
            'is_admin' => false,
        ]);
    }
}