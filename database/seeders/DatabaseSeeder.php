<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Asignar colores pastel a los veterinarios
        $colores = [
            '#FFB3C6', // rosa más vivo
            '#7FE7CC', // verde menta más vivo
            '#FFD6A5', // melocotón más vivo
            '#A0C4FF', // azul pastel más vivo
            '#B5F2A2', // verde lima más vivo
            '#FFFACD', // amarillo más vivo
            '#89CFF0', // azul cielo más vivo
            '#FFB7B2', // coral claro
            '#D0A2F7', // lavanda más vivo
            '#A3F7BF'  // verde agua más vivo
        ];
        $veterinarios = \App\Models\User::where('role', 'veterinario')->get();
        foreach ($veterinarios as $i => $vet) {
            $vet->color_calendario = $colores[$i % count($colores)];
            $vet->save();
        }
    }
}
