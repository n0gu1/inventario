<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name'     => 'Almacén Principal',
            'location' => 'Calle Principal 123, Ciudad',
        ]);

        Warehouse::create([
            'name'     => 'Almacén Secundario',
            'location' => 'zona 6 mixco',
        ]);
    }
}
