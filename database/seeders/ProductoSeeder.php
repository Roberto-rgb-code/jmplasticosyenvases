<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::insert([
            [
                'nombre' => 'Piña 960 ml Cristal',
                'capacidad_ml' => 960,
                'rosca' => 'R-28',
                'piezas_empaque' => 61,
                'imagen' => 'Piña 960 ml Cristal.png'
            ],
            [
                'nombre' => 'Botella Cilíndrica Lisa 500 ml',
                'capacidad_ml' => 500,
                'rosca' => 'R-28',
                'piezas_empaque' => 210,
                'imagen' => 'Botella Cilíndrica Lisa 500 ml.png'
            ],
            [
                'nombre' => 'Salsero Alto 5000 ml',
                'capacidad_ml' => 5000,
                'rosca' => 'R-48',
                'piezas_empaque' => 50,
                'imagen' => 'Salsero Alto 5000 ml.png'
            ],
            [
                'nombre' => 'Botella Agua 600 ml',
                'capacidad_ml' => 600,
                'rosca' => 'R-28',
                'piezas_empaque' => 144,
                'imagen' => 'Botella Agua 600 ml.png'
            ],
            [
                'nombre' => 'Botella de agua 500 ml',
                'capacidad_ml' => 500,
                'rosca' => 'R-28',
                'piezas_empaque' => 180,
                'imagen' => 'Botella de agua 500 ml.png'
            ],
            [
                'nombre' => 'Piña 5000 ml Asa Blanca',
                'capacidad_ml' => 5000,
                'rosca' => 'R-48',
                'piezas_empaque' => 50,
                'imagen' => 'Piña 5000 ml Asa Blanca.png'
            ],
            [
                'nombre' => 'Botella Boston 1000 ml',
                'capacidad_ml' => 1000,
                'rosca' => 'R-28',
                'piezas_empaque' => 100,
                'imagen' => 'Botella Boston 1000 ml.png'
            ],
            [
                'nombre' => 'Botella Boston 500 ml',
                'capacidad_ml' => 500,
                'rosca' => 'R-28',
                'piezas_empaque' => 200,
                'imagen' => 'Botella Boston 500 ml.png'
            ],
        ]);
    }
}
