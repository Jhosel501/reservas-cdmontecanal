<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Le decimos a Laravel qué Seeders ejecutar y en qué orden
        $this->call([
            PaqueteSeeder::class,
            ExtraSeeder::class,
        ]);
    }
}