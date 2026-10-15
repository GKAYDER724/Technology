@extends('layouts.app')

@section('title', 'Giỏ hàng - ElectroTech')

@section('content')
<main class="et-cart-page">
    <div class="et-cart-container">

        <!-- Breadcrumb -->
        <nav class="et-cart-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <span>Giỏ hàng của bạn (1 món)</span>
        </nav>

        <!-- Page heading -->
        <div class="et-cart-heading">
            <h1>Giỏ Hàng Mua Sắm (<span id="cart-item-count">1</span> sản phẩm)</h1>

            <button type="button" class="et-cart-clear" id="clear-cart">
                <i class="bi bi-trash3"></i>
                Xóa toàn bộ giỏ
            </button>
        </div>

        <!-- Cart layout -->
        <div class="et-cart-layout">

            <!-- Left: Product list -->
            <section class="et-cart-left">
                <div class="et-cart-products" id="cart-products">

                    <article class="et-cart-product"
                        data-price="6990000"
                        data-name="Tai nghe Chống ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio">

                        <a href="{{ url('/products/sony-wh1000xm5') }}"
                           class="et-cart-product-image">
                            <img
                                src="{{ asset('images/products/sony-wh1000xm5.jpg') }}"
                                alt="Tai nghe Sony WH-1000XM5"
                                onerror="this.onerror=null;this.src='https://placehold.co/120x120/ffda45/172033?text=SONY';">
                        </a>

                        <div class="et-cart-product-info">
                            <span class="et-cart-brand">SONY</span>

                            <a href="{{ url('/products/sony-wh1000xm5') }}"
                               class="et-cart-product-name">
                                Tai nghe Chống ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio
                            </a>

                            <p>Phân loại: <strong>Màu Đen Tinh Tế</strong></p>
                        </div>

                        <div class="et-cart-product-price">
                            <strong class="et-line-total">6.990.000₫</strong>
                            <span>6.990.000₫ / cái</span>
                        </div>

                        <div class="et-cart-quantity" aria-label="Số lượng sản phẩm">
                            <button type="button" class="et-qty-btn et-qty-minus"
                                    aria-label="Giảm số lượng">
                                <i class="bi bi-dash"></i>
                            </button>

                            <input type="number" class="et-qty-input"
                                   value="1" min="1" max="99"
                                   aria-label="Số lượng" readonly>

                            <button type="button" class="et-qty-btn et-qty-plus"
                                    aria-label="Tăng số lượng">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>

                        <button type="button" class="et-cart-remove"
                                aria-label="Xóa sản phẩm" title="Xóa sản phẩm">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </article>

                </div>

                <!-- Bottom of product list -->
                <div class="et-cart-continue">
                    <a href="{{ url('/products') }}">
                        <i class="bi bi-arrow-left"></i>
                        Tiếp tục chọn thêm sản phẩm khác
                    </a>

                    <span>Miễn phí giao hàng cho đơn từ 5 triệu</span>
                </div>

                <!-- Empty cart -->
                <div class="et-cart-empty" id="cart-empty" hidden>
                    <div class="et-cart-empty-icon">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <h2>Giỏ hàng đang trống</h2>
                    <p>Hãy khám phá các sản phẩm công nghệ tại ElectroTech.</p>
                    <a href="{{ url('/products') }}" class="et-cart-primary-btn">
                        Tiếp tục mua sắm
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </section>

            <!-- Right: Coupon and order summary -->
            <aside class="et-cart-right" id="cart-sidebar">

                <!-- Coupons -->
                <section class="et-cart-panel et-coupon-panel">
                    <h2 class="et-cart-panel-title">
                        <i class="bi bi-tag"></i>
                        Mã giảm giá &amp; Khuyến mãi
                    </h2>

                    <div class="et-coupon-applied" id="coupon-applied" hidden>
                        <div>
                            <strong>
                                <i class="bi bi-check-lg"></i>
                                Mã: <span id="applied-code">TECH500</span>
                            </strong>
                            <p id="applied-description">
                                Giảm ngay 500.000₫ cho đơn hàng từ 5.000.000₫
                            </p>
                        </div>

                        <button type="button" id="remove-coupon"
                                aria-label="Bỏ mã giảm giá">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="et-coupon-input-row">
                        <input type="text" id="coupon-input"
                               placeholder="Nhập mã giảm giá"
                               aria-label="Nhập mã giảm giá">
                        <button type="button" id="btn-apply-coupon">Áp dụng</button>
                    </div>

                    <div class="et-coupon-divider"></div>

                    <p class="et-coupon-list-heading">MÃ GIẢM GIÁ DÀNH CHO BẠN:</p>

                    <div class="et-coupon-list">

                        <button type="button" class="et-coupon-option"
                                data-code="TECH500">
                            <span>
                                <strong>TECH500</strong>
                                <small>Giảm ngay 500.000₫ cho đơn hàng từ 5.000.000₫</small>
                            </span>
                            <b>Dùng</b>
                        </button>

                        <button type="button" class="et-coupon-option"
                                data-code="FREESHIP">
                            <span>
                                <strong>FREESHIP</strong>
                                <small>Miễn phí vận chuyển toàn quốc cho mọi đơn hàng</small>
                            </span>
                            <b>Dùng</b>
                        </button>

                        <button type="button" class="et-coupon-option"
                                data-code="VIPMEMBER">
                            <span>
                                <strong>VIPMEMBER</strong>
                                <small>Đặc quyền Tech VIP: Giảm 1.000.000₫ cho đơn từ 20.000.000₫</small>
                            </span>
                            <b>Dùng</b>
                        </button>

                    </div>
                </section>

                <!-- Order summary -->
                <section class="et-cart-panel et-order-summary">
                    <h2 class="et-cart-panel-title">TÓM TẮT ĐƠN HÀNG</h2>

                    <div class="et-summary-row">
                        <span>Tạm tính tiền hàng:</span>
                        <strong id="cart-subtotal">6.990.000₫</strong>
                    </div>

                    <div class="et-summary-row">
                        <span>Phí vận chuyển:</span>
                        <strong class="et-free-shipping" id="cart-shipping">
                            Miễn phí
                        </strong>
                    </div>

                    <div class="et-summary-row et-discount-row">
                        <span>Giảm giá Voucher:</span>
                        <strong id="cart-discount">-500.000₫</strong>
                    </div>

                    <div class="et-summary-divider"></div>

                    <div class="et-summary-total">
                        <span>Tổng thanh toán:</span>
                        <strong id="cart-total">6.490.000₫</strong>
                    </div>

                    <p class="et-vat-note">(Đã bao gồm VAT 10%)</p>

                    <a href="{{ url('/checkout') }}"
                       class="et-cart-checkout-btn"
                       id="checkout-button">
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
    </div>
</main>
@endsection
