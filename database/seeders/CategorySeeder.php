<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([

            [
                'name' => 'Điện thoại',
                'status' => 'active',
                'parent_id' => null,
            ],

            [
                'name' => 'Phụ kiện',
                'status' => 'active',
                'parent_id' => null,
            ],

            [
                'name' => 'Laptop',
                'status' => 'active',
                'parent_id' => null,
            ],

            [
                'name' => 'iPhone',
                'status' => 'active',
                'parent_id' => 1,
            ],

            [
                'name' => 'Android',
                'status' => 'active',
                'parent_id' => 1,
            ],

            [
                'name' => 'Sạc & Cáp',
                'status' => 'active',
                'parent_id' => 2,
            ],

        ]);
    }
}