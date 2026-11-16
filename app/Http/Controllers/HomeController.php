<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy danh mục đang hoạt động
        $categories = DB::table('categories')
            ->where('status', 'active')
            ->get();

        // 2. Truy vấn ảnh đại diện
        $primaryImages = DB::table('product_images')
            ->where('is_primary', 1)
            ->select('product_id', 'image');

        // 3. Lấy tất cả sản phẩm kèm ảnh
        $products = DB::table('products as p')
            ->leftJoinSub($primaryImages, 'pi', function ($join) {
                $join->on('p.product_id', '=', 'pi.product_id');
            })
            ->select(
                'p.*',
                'pi.image as product_image'
            )
            ->get();

        // 4. Thống kê sản phẩm đã bán thành công
        $sales = DB::table('order_items as oi')
            ->join('orders as o', 'oi.order_id', '=', 'o.order_id')
            ->where('o.status', 'delivered')
            ->select(
                'oi.product_id',
                DB::raw('SUM(oi.quantity) AS total_sold'),
                DB::raw('SUM(oi.quantity * oi.unit_price) AS total_revenue')
            )
            ->groupBy('oi.product_id');

        // 5. Lấy 10 sản phẩm bán chạy kèm ảnh
        $bestSellingProducts = DB::table('products as p')
            ->joinSub($sales, 'sales', function ($join) {
                $join->on('p.product_id', '=', 'sales.product_id');
            })
            ->leftJoinSub($primaryImages, 'pi', function ($join) {
                $join->on('p.product_id', '=', 'pi.product_id');
            })
            ->select(
                'p.*',
                'pi.image as product_image',
                'sales.total_sold',
                'sales.total_revenue'
            )
            ->orderByDesc('sales.total_sold')
            ->limit(10)
            ->get();

        return view('home', compact(
            'categories',
            'products',
            'bestSellingProducts'
        ));
    }
}
