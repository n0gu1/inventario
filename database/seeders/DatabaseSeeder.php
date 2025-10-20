<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Laravel\Jetstream\Rules\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {


        $this->call([
            IdentitySeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class,
            ReasonSeeder::class,
            RoleSeeder::class,
        ]);

        Customer::factory(50)->create();
        Supplier::factory(50)->create();
        Product::factory(100)->create();
    }
}
