<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Trang danh sách sản phẩm ngoài Frontend
    public function index(Request $request)
    {
        $categories = Category::all();

        // Lấy các tham số từ request (nếu có)
        $search = $request->input('search');
        $selectedCategory = $request->input('category_id');
        $sort = $request->input('sort', 'popular');

        // Query từ bảng products thật trong Database
        $query = Product::with(['category', 'primaryImage', 'variants'])
            ->where('status', 'active');

        // Tìm kiếm theo tên
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lọc theo danh mục
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        // Sắp xếp
        if ($sort === 'price_asc') {
            $query->orderBy('base_price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('base_price', 'desc');
        } else {
            $query->latest('product_id'); // Mặc định mới nhất
        }

        $products = $query->paginate(12)->withQueryString();

        // Tạm thời giả lập giỏ hàng count (hoặc sau này gắn session giỏ hàng sau)
        $cartCount = 0; 

        return view('products.index', [
            'categories' => $categories,
            'products' => $products,
            'totalCount' => $products->total(),
            'search' => $search,
            'selectedCategory' => $selectedCategory,
            'sort' => $sort,
            'cartCount' => $cartCount
        ]);
    }

    // Trang chi tiết sản phẩm ngoài Frontend
    public function show($id)
    {
        // Lấy sản phẩm theo ID kèm theo ảnh thư viện và các biến thể
        $product = Product::with(['category', 'images', 'variants'])
            ->where('product_id', $id)
            ->where('status', 'active')
            ->firstOrFail();

        // Lấy sản phẩm liên quan cùng danh mục
        $relatedProducts = Product::with(['primaryImage'])
            ->where('category_id', $product->category_id)
            ->where('product_id', '!=', $id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        $cartCount = 0;

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'cartCount' => $cartCount
        ]);
    }
}