@extends('layouts.app')

@section('title', 'Giỏ hàng - ElectroTech')

@section('content')

    <main class="et-cart-page">
        <div class="et-cart-container">

            {{-- Breadcrumb --}}
            <nav class="et-cart-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Trang chủ</a>
                <i class="bi bi-chevron-right"></i>
                <span>Giỏ hàng của bạn ({{ $cartCount ?? 0 }} món)</span>
            </nav>

            {{-- Page heading --}}
            <div class="et-cart-heading">
                <h1>
                    Giỏ Hàng Mua Sắm
                    (<span id="cart-item-count">{{ $cartCount ?? 0 }}</span> sản phẩm)
                </h1>

                @if (isset($cartItems) && $cartItems->isNotEmpty())
                    <span class="et-cart-product-count">
                        {{ $cartItems->count() }} loại sản phẩm
                    </span>
                @endif
            </div>

            {{-- Kiểm tra giỏ hàng --}}
            @if (!isset($cartItems) || $cartItems->isEmpty())

                {{-- EMPTY CART --}}
                <section class="et-cart-empty" id="cart-empty">

                    <div class="et-cart-empty-icon">
                        <i class="bi bi-cart3"></i>
                    </div>

                    <h2>Giỏ hàng đang trống</h2>

                    <p>
                        Bạn chưa có sản phẩm nào trong giỏ hàng.
                        Hãy khám phá các sản phẩm công nghệ tại ElectroTech.
                    </p>

                    <a href="{{ route('products.index') }}" class="et-cart-primary-btn">
                        Tiếp tục mua sắm
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </section>
            @else
                {{-- Cart layout --}}
                <div class="et-cart-layout">

                    {{-- Left: Product list --}}
                    <section class="et-cart-left">

                        <div class="et-cart-products" id="cart-products">

                            {{-- Duyệt danh sách sản phẩm từ database --}}
                            @foreach ($cartItems as $item)
                                <article class="et-cart-product" data-cart-item-id="{{ $item->cart_item_id }}"
                                    data-price="{{ $item->unit_price }}" data-name="{{ $item->product_name }}">

                                    {{-- Product image --}}
                                    <a href="{{ url('/products/' . $item->product_id) }}" class="et-cart-product-image">
                                        @if (!empty($item->product_image))
                                            <img src="{{ asset('storage/' . $item->product_image) }}"
                                                alt="{{ $item->product_name }}"
                                                onerror="this.onerror=null;this.src='https://placehold.co/120x120/ffda45/172033?text=ElectroTech';">
                                        @else
                                            <img src="https://placehold.co/120x120/ffda45/172033?text=ElectroTech"
                                                alt="Không có ảnh sản phẩm">
                                        @endif
                                    </a>

                                    {{-- Product information --}}
                                    <div class="et-cart-product-info">

                                        <a href="{{ url('/products/' . $item->product_id) }}" class="et-cart-product-name">
                                            {{ $item->product_name }}
                                        </a>

                                        @if (!empty($item->variant_name))
                                            <p>
                                                Phân loại:
                                                <strong>{{ $item->variant_name }}</strong>
                                            </p>
                                        @endif

                                        @if (!empty($item->variant_id))
                                            <p>
                                                <small>Mã biến thể: {{ $item->variant_id }}</small>
                                            </p>
                                        @endif

                                    </div>

                                    {{-- Product price --}}
                                    <div class="et-cart-product-price">

                                        <strong class="et-line-total">
                                            {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}₫
                                        </strong>

                                        <span>
                                            {{ number_format($item->unit_price, 0, ',', '.') }}₫ / cái
                                        </span>

                                    </div>

                                    {{-- QUANTITY & REMOVE --}}
                                    <div class="et-cart-quantity">

                                        {{-- Form cập nhật số lượng --}}
                                        <form action="{{ route('cart.update', $item->cart_item_id) }}" method="POST"
                                            class="et-quantity-form">

                                            @csrf
                                            @method('PATCH')

                                            <div class="et-quantity-control">

                                                <button type="button" class="et-qty-btn"
                                                    onclick="
                                                        const input = this.parentElement.querySelector('.et-qty-input');
                                                        input.value = Math.max(1, Number(input.value) - 1);
                                                        this.form.requestSubmit();
                                                    ">
                                                    <i class="bi bi-dash"></i>
                                                </button>

                                                <input type="number" name="quantity" class="et-qty-input"
                                                    value="{{ $item->quantity }}" min="1" required>

                                                <button type="button" class="et-qty-btn"
                                                    onclick="
                                                        const input = this.parentElement.querySelector('.et-qty-input');
                                                        input.value = Number(input.value) + 1;
                                                        this.form.requestSubmit();
                                                    ">
                                                    <i class="bi bi-plus"></i>
                                                </button>

                                            </div>

                                        </form>

                                        {{-- Form xóa sản phẩm --}}
                                        <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST"
                                            class="et-remove-form"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="et-remove-btn">
                                                <i class="bi bi-trash3"></i>
                                                Xóa sản phẩm
                                            </button>

                                        </form>

                                    </div>

                                    {{-- Remove button sẽ tích hợp khi có route xóa sản phẩm --}}

                                </article>
                            @endforeach

                        </div>

                        {{-- Bottom of product list --}}
                        <div class="et-cart-continue">

                            <a href="{{ route('products.index') }}">
                                <i class="bi bi-arrow-left"></i>
                                Tiếp tục chọn thêm sản phẩm khác
                            </a>

                            <span>
                                Miễn phí giao hàng cho đơn từ 5 triệu
                            </span>

                        </div>

                    </section>

                    {{-- Right: Coupon and order summary --}}
                    <aside class="et-cart-right" id="cart-sidebar">

                        {{-- Coupons --}}
                        <section class="et-cart-panel et-coupon-panel">

                            <h2 class="et-cart-panel-title">
                                <i class="bi bi-tag"></i>
                                Mã giảm giá &amp; Khuyến mãi
                            </h2>

                            <div class="et-coupon-list">

                                <div class="et-coupon-option">
                                    <span>
                                        <strong>TECH500</strong>
                                        <small>
                                            Giảm 500.000₫ cho đơn hàng từ 5.000.000₫
                                        </small>
                                    </span>
                                </div>

                                <div class="et-coupon-option">
                                    <span>
                                        <strong>FREESHIP</strong>
                                        <small>
                                            Ưu đãi miễn phí vận chuyển theo điều kiện áp dụng
                                        </small>
                                    </span>
                                </div>

                                <div class="et-coupon-option">
                                    <span>
                                        <strong>VIPMEMBER</strong>
                                        <small>
                                            Ưu đãi dành cho khách hàng thành viên
                                        </small>
                                    </span>
                                </div>

                            </div>

                            <p class="et-coupon-note">
                                Ưu đãi sẽ được áp dụng khi hệ thống xác nhận điều kiện đơn hàng.
                            </p>

                        </section>

                        {{-- Order summary --}}
                        <section class="et-cart-panel et-order-summary">

                            <h2 class="et-cart-panel-title">
                                TÓM TẮT ĐƠN HÀNG
                            </h2>

                            <div class="et-summary-row">
                                <span>Tổng số lượng sản phẩm:</span>
                                <strong>{{ $cartCount ?? 0 }}</strong>
                            </div>

                            <div class="et-summary-row">
                                <span>Tạm tính tiền hàng:</span>

                                <strong id="cart-subtotal">
                                    {{ number_format($subtotal ?? 0, 0, ',', '.') }}₫
                                </strong>
                            </div>

                            <div class="et-summary-row">
                                <span>Phí vận chuyển:</span>

                                <strong class="et-free-shipping" id="cart-shipping">
                                    @if (($shipping ?? 0) > 0)
                                        {{ number_format($shipping, 0, ',', '.') }}₫
                                    @else
                                        Miễn phí
                                    @endif
                                </strong>
                            </div>

                            <div class="et-summary-row et-discount-row">
                                <span>Giảm giá Voucher:</span>

                                <strong id="cart-discount">
                                    -{{ number_format($discount ?? 0, 0, ',', '.') }}₫
                                </strong>
                            </div>

                            <div class="et-summary-divider"></div>

                            <div class="et-summary-total">

                                <span>Tổng thanh toán:</span>

                                <strong id="cart-total">
                                    {{ number_format($total ?? 0, 0, ',', '.') }}₫
                                </strong>

                            </div>

                            <p class="et-vat-note">
                                (Đã bao gồm VAT 10%)
                            </p>

                            <a href="{{ url('/checkout') }}" class="et-cart-checkout-btn" id="checkout-button">
                                Tiến Hành Đặt Hàng
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <div class="et-cart-security">

                                <p>
                                    <i class="bi bi-shield-check"></i>
                                    Bảo mật thanh toán 100% chuẩn mã hóa SSL
                                </p>

                                <p>
                                    <i class="bi bi-truck"></i>
                                    Kiểm tra hàng trước khi thanh toán (COD)
                                </p>

                            </div>

                        </section>

                    </aside>

                </div>

            @endif

        </div>
    </main>

@endsection
