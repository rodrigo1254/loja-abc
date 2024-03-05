<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        
        //\App\Models\Product::factory(5)->create();

        \App\Models\Product::factory()->create([
            'name' => 'Celular 1',
            'price' => 1800,
            'description' => 'Lorenzo Ipsulum',
        ]);
        
        \App\Models\Product::factory()->create([
            'name' => 'Celular 2',
            'price' => 3200,
            'description' => 'Lorem ipsum dolor',
        ]);
        
        \App\Models\Product::factory()->create([
            'name' => 'Celular 3',
            'price' => 9800,
            'description' => 'Lorem ipsum dolor sit amet',
        ]);

        $product_id = \App\Models\Product::all()->random()->id;
        $product = \App\Models\Product::find($product_id);

        \App\Models\SaleProduct::factory(1)->create([
            'sale_id' => \App\Models\Sale::factory(),
            'product_id' => $product_id,
            'price' => $product->price
        ]);

    }
}
