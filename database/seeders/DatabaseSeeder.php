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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /*\App\Models\SaleProduct::factory(2)
            ->hasSales()   
            ->hasProducts()
            ->create();*/

        /*\App\Models\SaleProduct::factory(2)
        ->has(\App\Models\Sale::factory())
        ->has(\App\Models\Product::factory(2))
        ->create();*/
        
        \App\Models\SaleProduct::factory(1)->create([
            'sale_id' => \App\Models\Sale::factory(),
            'product_id' => \App\Models\Product::factory(),
        ]);

    }
}
