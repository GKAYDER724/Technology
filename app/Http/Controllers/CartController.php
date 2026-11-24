<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Lấy giỏ hàng của người dùng đang đăng nhập.
     * Nếu chưa có thì tạo giỏ hàng mới.
     */
    private function getUserCart(): Cart
    {
        return Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }
    public function index()
    {
        // Lấy ID người dùng đang đăng nhập
        $userId = Auth::user()->getAuthIdentifier();

        // Lấy giỏ hàng của người dùng
        $cart = DB::table('carts')
            ->where('user_id', $userId)
            ->first();

        // Mặc định giỏ hàng rỗng
        $cartItems = collect();

        // Nếu người dùng đã có giỏ hàng thì lấy danh sách sản phẩm
        if ($cart) {
            $cartItems = DB::table('cart_items as ci')
                ->join('products as p', 'ci.product_id', '=', 'p.product_id')
                ->leftJoin(
                    'product_variants as pv',
                    'ci.variant_id',
                    '=',
                    'pv.variant_id'
                )
                ->leftJoin('product_images as pi', function ($join) {
                    $join->on('p.product_id', '=', 'pi.product_id')
                        ->where('pi.is_primary', 1);
                })
                ->where('ci.cart_id', $cart->cart_id)
                ->select(
                    'ci.cart_item_id',
                    'ci.product_id',
                    'ci.variant_id',
                    'ci.quantity',
                    'ci.unit_price',
                    'p.name as product_name',
                    'p.stock as product_stock',
                    'pv.variant_name',
                    'pv.stock as variant_stock',
                    DB::raw("
                        COALESCE(
                            NULLIF(pv.image, ''),
                            pi.image
                        ) as product_image
                    ")
                )
                ->orderByDesc('ci.cart_item_id')
                ->get();
        }

        // Tính tổng tiền sản phẩm
        $subtotal = $cartItems->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        // Tổng số lượng sản phẩm trong giỏ
        $cartCount = $cartItems->sum('quantity');

        // Tạm thời chưa áp dụng giảm giá và phí vận chuyển
        $discount = 0;
        $shipping = 0;
        $total = $subtotal - $discount + $shipping;

        return view('cart', compact(
            'cart',
            'cartItems',
            'cartCount',
            'subtotal',
            'discount',
            'shipping',
            'total'
        ));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng.
     */
    public function add(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'variant_id' => ['nullable', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
            'buy_now' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $id) {
                $product = DB::table('products')
                    ->where('product_id', $id)
                    ->where('status', 'active')
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \Exception('Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.');
                }

                $variant = null;

                $hasVariants = DB::table('product_variants')
                    ->where('product_id', $id)
                    ->where('status', 'active')
                    ->exists();

                if ($hasVariants && !$request->filled('variant_id')) {
                    throw new \Exception('Vui lòng chọn phiên bản sản phẩm.');
                }

                if ($request->filled('variant_id')) {
                    $variant = DB::table('product_variants')
                        ->where('variant_id', $request->variant_id)
                        ->where('product_id', $id)
                        ->where('status', 'active')
                        ->lockForUpdate()
                        ->first();

                    if (!$variant) {
                        throw new \Exception('Phiên bản sản phẩm không hợp lệ.');
                    }
                }

                $stock = $variant
                    ? (int) $variant->stock
                    : (int) $product->stock;

                if ($stock <= 0) {
                    throw new \Exception('Sản phẩm hiện đã hết hàng.');
                }

                $price = $variant
                    ? (
                        $variant->sale_price > 0
                        ? $variant->sale_price
                        : $variant->price
                    )
                    : (
                        $product->sale_price > 0
                        ? $product->sale_price
                        : $product->base_price
                    );

                $cart = $this->getUserCart();

                $itemQuery = CartItem::where('cart_id', $cart->cart_id)
                    ->where('product_id', $id);

                if ($variant) {
                    $itemQuery->where('variant_id', $variant->variant_id);
                } else {
                    $itemQuery->whereNull('variant_id');
                }

                $cartItem = $itemQuery->lockForUpdate()->first();

                $quantity = (int) $request->quantity;
                $newQuantity = $quantity + ($cartItem ? $cartItem->quantity : 0);

                if ($newQuantity > $stock) {
                    throw new \Exception(
                        "Số lượng vượt quá tồn kho. Hiện chỉ còn {$stock} sản phẩm."
                    );
                }

                if ($cartItem) {
                    $cartItem->update([
                        'quantity' => $newQuantity,
                        'unit_price' => $price,
                    ]);
                } else {
                    CartItem::create([
                        'cart_id' => $cart->cart_id,
                        'product_id' => $id,
                        'variant_id' => $variant?->variant_id,
                        'quantity' => $quantity,
                        'unit_price' => $price,
                    ]);
                }

                return [
                    'cart_count' => CartItem::where('cart_id', $cart->cart_id)
                        ->sum('quantity'),
                    'buy_now' => $request->boolean('buy_now'),
                ];
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
                    'cart_count' => $result['cart_count'],
                    'redirect' => $result['buy_now']
                        ? route('cart.index')
                        : null,
                ]);
            }

            return redirect()
                ->route('cart.index')
                ->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm.
     */
    public function update(Request $request, $cartItemId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getUserCart();

        $item = CartItem::where('cart_id', $cart->cart_id)
            ->where('cart_item_id', $cartItemId)
            ->with(['product', 'variant'])
            ->firstOrFail();

        // Lấy tồn kho theo biến thể hoặc sản phẩm
        if ($item->variant_id) {
            $stock = $item->variant?->stock ?? 0;
        } else {
            $stock = $item->product?->stock ?? 0;
        }

        if ($validated['quantity'] > $stock) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
        }

        // Cập nhật số lượng trong cart_items
        $item->quantity = $validated['quantity'];
        $item->save();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Đã cập nhật số lượng sản phẩm.');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng.
     */
    public function remove($cartItemId)
    {
        $cart = $this->getUserCart();

        CartItem::where('cart_item_id', $cartItemId)
            ->where('cart_id', $cart->cart_id)
            ->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
