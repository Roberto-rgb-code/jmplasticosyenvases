<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $nombresAEliminar = [
            'Piña 960 ml Cristal',
            'Botella Cilíndrica Lisa 500 ml',
            'Botella Agua 600 ml',
            'Botella de agua 500 ml',
            'Botella Boston 1000 ml',
            'Botella Boston 500 ml',
        ];

        Producto::whereIn('nombre', $nombresAEliminar)->delete();

        $catalogo = [
            [
                'nombre' => 'Salsero Alto 5000 ml',
                'capacidad_ml' => 5000,
                'rosca' => 'R-48',
                'piezas_empaque' => 50,
                'imagen' => 'salsero-alto-5000.png',
            ],
            [
                'nombre' => 'Piña 5000 ml Asa Blanca',
                'capacidad_ml' => 5000,
                'rosca' => 'R-48',
                'piezas_empaque' => 50,
                'imagen' => 'pina-5000-asa-blanca.png',
            ],
        ];

        foreach ($catalogo as $item) {
            Producto::updateOrCreate(
                ['nombre' => $item['nombre']],
                $item
            );
        }
    }
}
