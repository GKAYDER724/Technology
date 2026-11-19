<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index(Request $request)
    {
        // 1. Lấy danh mục đang hoạt động
        $categories = DB::table('categories')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // 2. Xây dựng cây danh mục cha - con
        $buildTree = function ($parentId) use (&$buildTree, $categories) {
            return $categories
                ->where('parent_id', $parentId)
                ->map(function ($category) use (&$buildTree) {
                    $category->children = $buildTree($category->category_id);

                    return $category;
                })
                ->values();
        };

        $categoryTree = $categories
            ->filter(function ($category) {
                return $category->parent_id === null
                    || $category->parent_id == 0;
            })
            ->map(function ($category) use (&$buildTree) {
                $category->children = $buildTree($category->category_id);

                return $category;
            })
            ->values();

        // 3. Lấy ảnh chính của sản phẩm
        $primaryImages = DB::table('product_images')
            ->where('is_primary', 1)
            ->select('product_id', 'image');

        // 4. Truy vấn sản phẩm
        $query = DB::table('products as p')
            ->leftJoinSub($primaryImages, 'pi', function ($join) {
                $join->on('p.product_id', '=', 'pi.product_id');
            })
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->where('p.status', 'active')
            ->select(
                'p.*',
                'pi.image as product_image',
                'c.name as category_name'
            );

        // 5. Lọc danh mục cha và toàn bộ danh mục con
        $selectedCategory = $request->input('category', 'all');

        if ($selectedCategory !== 'all' && is_numeric($selectedCategory)) {
            $categoryIds = [(int) $selectedCategory];
            $parentIds = [(int) $selectedCategory];

            while (!empty($parentIds)) {
                $children = $categories
                    ->whereIn('parent_id', $parentIds)
                    ->pluck('category_id')
                    ->map(fn($id) => (int) $id)
                    ->all();

                $children = array_values(array_diff($children, $categoryIds));

                if (empty($children)) {
                    break;
                }

                $categoryIds = array_merge($categoryIds, $children);
                $parentIds = $children;
            }

            $query->whereIn('p.category_id', $categoryIds);
        }

        // 6. Tìm kiếm sản phẩm theo tên
        $search = trim($request->input('search', ''));

        if ($search !== '') {
            $query->where('p.name', 'like', '%' . $search . '%');
        }

        // 7. Lọc theo khoảng giá
        $selectedPrice = $request->input('price', 'all');

        $effectivePrice = 'COALESCE(NULLIF(p.sale_price, 0), p.base_price)';

        switch ($selectedPrice) {
            case 'under5':
                $query->whereRaw("$effectivePrice < ?", [5000000]);
                break;

            case '5to15':
                $query->whereRaw("$effectivePrice >= ?", [5000000])
                    ->whereRaw("$effectivePrice <= ?", [15000000]);
                break;

            case '15to30':
                $query->whereRaw("$effectivePrice > ?", [15000000])
                    ->whereRaw("$effectivePrice <= ?", [30000000]);
                break;

            case 'over30':
                $query->whereRaw("$effectivePrice > ?", [30000000]);
                break;
        }

        // 8. Chỉ hiển thị sản phẩm còn hàng nếu được chọn
        $inStockOnly = $request->boolean('in_stock');

        if ($inStockOnly) {
            $query->where('p.stock', '>', 0);
        }

        // 9. Sắp xếp sản phẩm
        $sort = $request->input('sort', 'newest');

        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw("$effectivePrice ASC");
                break;

            case 'price_desc':
                $query->orderByRaw("$effectivePrice DESC");
                break;

            case 'newest':
            default:
                $query->orderByDesc('p.product_id');
                break;
        }

        // 10. Phân trang
        $products = $query->paginate(12)->withQueryString();

        // 11. Các mức giá hiển thị trên giao diện
        $priceRanges = [
            'all' => 'Tất cả mức giá',
            'under5' => 'Dưới 5 triệu',
            '5to15' => 'Từ 5 - 15 triệu',
            '15to30' => 'Từ 15 - 30 triệu',
            'over30' => 'Trên 30 triệu',
        ];

        return view('products.index', compact(
            'products',
            'categories',
            'categoryTree',
            'selectedCategory',
            'selectedPrice',
            'priceRanges',
            'search',
            'sort',
            'inStockOnly'
        ));
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */

    public function show($id)
    {
        // 1. LẤY THÔNG TIN SẢN PHẨM
        $product = DB::table('products as p')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.category_id')
            ->where('p.product_id', $id)
            ->where('p.status', 'active')
            ->select(
                'p.*',
                'c.name as category_name'
            )
            ->first();

        // Không tìm thấy sản phẩm thì trả về trang 404
        abort_if(!$product, 404);

        // 2. LẤY DANH SÁCH ẢNH CỦA SẢN PHẨM
        // Ảnh chính được đưa lên đầu danh sách
        $productImages = DB::table('product_images')
            ->where('product_id', $product->product_id)
            ->orderByDesc('is_primary')
            ->orderBy('image_id')
            ->get();

        // 3. LẤY CÁC PHIÊN BẢN CỦA SẢN PHẨM
        $variants = DB::table('product_variants')
            ->where('product_id', $product->product_id)
            ->where('status', 'active')
            ->orderBy('variant_id')
            ->get();

        // 4. LẤY SẢN PHẨM LIÊN QUAN CÙNG DANH MỤC
        $relatedImages = DB::table('product_images')
            ->where('is_primary', 1)
            ->select('product_id', 'image');

        $relatedProducts = DB::table('products as p')
            ->leftJoinSub($relatedImages, 'pi', function ($join) {
                $join->on('p.product_id', '=', 'pi.product_id');
            })
            ->where('p.category_id', $product->category_id)
            ->where('p.product_id', '<>', $product->product_id)
            ->where('p.status', 'active')
            ->select(
                'p.product_id',
                'p.name',
                'p.base_price',
                'p.sale_price',
                'pi.image as product_image'
            )
            ->orderByDesc('p.product_id')
            ->limit(4)
            ->get();

        // 5. TRUYỀN DỮ LIỆU SANG VIEW
        return view('products.show', compact(
            'product',
            'productImages',
            'variants',
            'relatedProducts'
        ));
    }
}
