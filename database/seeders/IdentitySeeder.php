<?php

namespace Database\Seeders;

use App\Models\Identity as ModelsIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Identity;


class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identities = [
            'Sin documento',
            'DPI',
            'Pasaporte',
            'RUC',
        ];

       foreach ($identities as $identity) {
            Identity::create([
                'name' => $identity,
            ]);
        }

    }
}
