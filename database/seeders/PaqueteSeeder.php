<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Añadimos esta línea para poder hablar con la BD

class PaqueteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertamos los paquetes en forma de array múltiple
        DB::table('paquetes')->insert([
            [
                'nombre' => 'Pequeña',
                'max_personas' => 20,
                'precio' => 200.00,
                'nota' => 'Espacio compartido con otros grupos',
                'exclusividad' => false,
            ],
            [
                'nombre' => 'Mediana',
                'max_personas' => 40,
                'precio' => 350.00,
                'nota' => 'Espacio compartido con otro grupo',
                'exclusividad' => false,
            ],
            [
                'nombre' => 'Grande',
                'max_personas' => 60,
                'precio' => 400.00,
                'nota' => 'Instalaciones en exclusividad',
                'exclusividad' => true,
            ]
        ]);
    }
}
