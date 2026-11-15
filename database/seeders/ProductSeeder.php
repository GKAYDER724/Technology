<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([

            [
                'category_id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Điện thoại Apple cao cấp',
                'base_price' => 28000000,
                'sale_price' => 26000000,
                'stock' => 10,
                'status' => 'active',
            ],


            [
                'category_id' => 1,
                'name' => 'Samsung Galaxy S25',
                'description' => 'Điện thoại Android flagship',
                'base_price' => 22000000,
                'sale_price' => 20000000,
                'stock' => 15,
                'status' => 'active',
            ],


            [
                'category_id' => 2,
                'name' => 'Cáp sạc Type C',
                'description' => 'Cáp sạc nhanh',
                'base_price' => 200000,
                'sale_price' => 150000,
                'stock' => 50,
                'status' => 'active',
            ],


            [
                'category_id' => 3,
                'name' => 'Laptop Asus Gaming',
                'description' => 'Laptop gaming mạnh mẽ',
                'base_price' => 25000000,
                'sale_price' => 23000000,
                'stock' => 5,
                'status' => 'active',
            ],

        ]);
    }
}