<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtraSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('extras')->insert([
            ['nombre' => 'Barril Ámbar 30L', 'precio' => 70.00, 'descripcion' => '~120 cañas', 'permite_cantidad' => true],
            ['nombre' => 'Vasos de plástico', 'precio' => 3.00, 'descripcion' => 'pack 50 ud', 'permite_cantidad' => true],
            ['nombre' => 'Hielo', 'precio' => 2.00, 'descripcion' => 'bolsa ~2kg', 'permite_cantidad' => true],
            ['nombre' => 'Carbón vegetal', 'precio' => 5.00, 'descripcion' => 'bolsa 3kg', 'permite_cantidad' => true],
            ['nombre' => 'Refrescos', 'precio' => 1.00, 'descripcion' => 'unidad', 'permite_cantidad' => true],
            ['nombre' => 'Servilletas', 'precio' => 3.00, 'descripcion' => 'rollo', 'permite_cantidad' => true],
            ['nombre' => 'Platos de plástico', 'precio' => 2.00, 'descripcion' => '20 unidades', 'permite_cantidad' => true],
            ['nombre' => 'Agua 1L', 'precio' => 1.00, 'descripcion' => 'botella', 'permite_cantidad' => true],
        ]);
    }
}