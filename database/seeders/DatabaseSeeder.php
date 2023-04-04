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

        \App\Models\Products::create([
            'product_name' => 'Sosis',
            'product_image' => 'images/beef.png',
            'product_stock' => 0,
        ]);

        \App\Models\ProductVariants::create([
            'product_id' => 1,
            'level' => 'ecer',
            'type' => 'pcs',
            'price' => 12000,
        ]);
    }
}
