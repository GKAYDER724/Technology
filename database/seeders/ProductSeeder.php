<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 8,
                'name' => 'iPhone 18 Pro - Sản phẩm mẫu',
                'description' => 'Sản phẩm mẫu kiểm thử quản lý sản phẩm và biến thể.',
                'base_price' => 32990000,
                'sale_price' => null,
                'stock' => 0,
                'status' => 'active',
                'images' => [
                    'iphone-18-pro-02-1.webp',
                    'iphone-18-pro-11.webp',
                ],
                'variants' => [
                    [
                        'variant_name' => '256GB - Màu đen',
                        'sku' => 'TEST-IP18P-256-BLK',
                        'price' => 32990000,
                        'sale_price' => null,
                        'stock' => 5,
                        'status' => 'active',
                        'image' => 'iphone-18-pro-02-1.webp',
                    ],
                    [
                        'variant_name' => '512GB - Màu tự nhiên',
                        'sku' => 'TEST-IP18P-512-NAT',
                        'price' => 35990000,
                        'sale_price' => null,
                        'stock' => 3,
                        'status' => 'active',
                        'image' => 'iphone-18-pro-11.webp',
                    ],
                ],
            ],
            [
                'category_id' => 9,
                'name' => 'Samsung Galaxy - Sản phẩm mẫu',
                'description' => 'Sản phẩm mẫu kiểm thử biến thể điện thoại Android.',
                'base_price' => 18990000,
                'sale_price' => null,
                'stock' => 0,
                'status' => 'active',
                'images' => [
                    'go8rapBIXYeRq9iYuXtFE3WEKphP2dBgXjw3KNZ0.jpg',
                    'shopping.webp',
                ],
                'variants' => [
                    [
                        'variant_name' => '256GB',
                        'sku' => 'TEST-SAM-256',
                        'price' => 18990000,
                        'sale_price' => null,
                        'stock' => 4,
                        'status' => 'active',
                        'image' => 'go8rapBIXYeRq9iYuXtFE3WEKphP2dBgXjw3KNZ0.jpg',
                    ],
                    [
                        'variant_name' => '512GB',
                        'sku' => 'TEST-SAM-512',
                        'price' => 20990000,
                        'sale_price' => null,
                        'stock' => 2,
                        'status' => 'active',
                        'image' => 'shopping.webp',
                    ],
                ],
            ],
            [
                'category_id' => 10,
                'name' => 'Củ sạc mẫu kiểm thử',
                'description' => 'Sản phẩm không có biến thể, dùng kiểm tra giá và tồn kho.',
                'base_price' => 350000,
                'sale_price' => 299000,
                'stock' => 20,
                'status' => 'active',
                'images' => [
                    's-l960-510x603.webp',
                ],
                'variants' => [],
            ],
            [
                'category_id' => 3,
                'name' => 'Phụ kiện mẫu kiểm thử hình ảnh',
                'description' => 'Sản phẩm mẫu kiểm tra hiển thị ảnh.',
                'base_price' => 150000,
                'sale_price' => null,
                'stock' => 10,
                'status' => 'active',
                'images' => [
                    'nike-m-air-max-moto-2k-shoes.jpg',
                ],
                'variants' => [],
            ],
        ];

        foreach ($products as $item) {
            $product = Product::firstOrCreate(
                [
                    'name' => $item['name'],
                    'category_id' => $item['category_id'],
                ],
                [
                    'description' => $item['description'],
                    'base_price' => $item['base_price'],
                    'sale_price' => $item['sale_price'],
                    'stock' => $item['stock'],
                    'status' => $item['status'],
                ]
            );

            // Thêm ảnh thư viện sản phẩm
            foreach ($item['images'] as $index => $filename) {
                $path = 'products/gallery/' . $filename;

                if (! Storage::disk('public')->exists($path)) {
                    $this->command->warn("Không tìm thấy ảnh: {$path}");
                    continue;
                }

                ProductImage::firstOrCreate(
                    [
                        'product_id' => $product->product_id,
                        'image' => $path,
                    ],
                    [
                        'is_primary' => $index === 0,
                    ]
                );
            }

            // Thêm biến thể
            foreach ($item['variants'] as $variant) {
                $imagePath = 'products/gallery/' . $variant['image'];

                if (! Storage::disk('public')->exists($imagePath)) {
                    $this->command->warn("Không tìm thấy ảnh biến thể: {$imagePath}");
                    continue;
                }

                ProductVariant::firstOrCreate(
                    [
                        'sku' => $variant['sku'],
                    ],
                    [
                        'product_id' => $product->product_id,
                        'variant_name' => $variant['variant_name'],
                        'image' => $imagePath,
                        'price' => $variant['price'],
                        'sale_price' => $variant['sale_price'],
                        'stock' => $variant['stock'],
                        'status' => $variant['status'],
                    ]
                );
            }

            // Đồng bộ giá và tồn kho tổng từ biến thể
            $variants = $product->variants();

            if ($variants->exists()) {
                $product->update([
                    'base_price' => $variants->min('price'),
                    'sale_price' => null,
                    'stock' => $variants->sum('stock'),
                ]);
            }
        }

        $this->command->info('Đã hoàn thành ProductSeeder!');
    }
}
