<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronicos', 'description' => 'Articulos electronicos'],
            ['name' => 'Ropa',         'description' => 'Articulos de ropa'],
            ['name' => 'Alimentos',    'description' => 'Articulos de alimentos'],
            ['name' => 'Hogar',        'description' => 'Articulos para el hogar'],
            ['name' => 'Juguetes',     'description' => 'Articulos de juguetes'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(           
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
