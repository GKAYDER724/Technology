<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tìm hoặc lấy các danh mục cha có sẵn dựa theo CSDL của cậu
        $dienThoai = Category::firstOrCreate(
            ['name' => 'Dien thoại'],
            [
                'slug' => Str::slug('Dien thoại'),
                'status' => 'active',
                'parent_id' => null
            ]
        );

        $phuKien = Category::firstOrCreate(
            ['name' => 'Phu kien'],
            [
                'slug' => Str::slug('Phu kien'),
                'status' => 'active',
                'parent_id' => null
            ]
        );

        // 2. Thêm các danh mục con chuyên sâu cho đồ án bán điện thoại
        // Danh mục con của "Dien thoại"
        Category::firstOrCreate(
            ['name' => 'iPhone (Apple)'],
            [
                'slug' => Str::slug('iPhone Apple'),
                'status' => 'active',
                'parent_id' => $dienThoai->category_id,
            ]
        );

        Category::firstOrCreate(
            ['name' => 'Điện thoại Android'],
            [
                'slug' => Str::slug('Dien thoai Android'),
                'status' => 'active',
                'parent_id' => $dienThoai->category_id,
            ]
        );

        // Danh mục con của "Phu kien"
        Category::firstOrCreate(
            ['name' => 'Sạc & Cáp điện thoại'],
            [
                'slug' => Str::slug('Sac va Cap dien thoai'),
                'status' => 'active',
                'parent_id' => $phuKien->category_id,
            ]
        );

        Category::firstOrCreate(
            ['name' => 'Ốp lưng & Kính cường lực'],
            [
                'slug' => Str::slug('Op lung va Kinh cuong luc'),
                'status' => 'active',
                'parent_id' => $phuKien->category_id,
            ]
        );
    }
}