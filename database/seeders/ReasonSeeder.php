<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            // Razones de ingreso
            ['name' => 'Ajuste de inventario', 'type' => 1],
            ['name' => 'Devolución de cliente', 'type' => 2],
            ['name' => 'Produccion Terminada', 'type' => 1],
            ['name' => 'Error en salida anterior', 'type' => 1],

            // Razones de salida
            ['name' => 'Ajuste de inventario', 'type' => 2],
            ['name' => 'Devolución de cliente', 'type' => 2],
            ['name' => 'Error en salida anterior', 'type' => 1],
        ];

        foreach ($reasons as $reason) {
            \App\Models\Reason::create($reason);
        } 
    }
}
