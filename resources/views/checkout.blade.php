@extends('layouts.app')

@section('title', 'Thanh Toán Đơn Hàng - ElectroStore')

@section('content')
<div class="checkout-page">

    {{-- Breadcrumb --}}
    <nav class="checkout-breadcrumb" aria-label="breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <span>›</span>
        <a href="{{ url('/cart') }}">Giỏ hàng</a>
        <span>›</span>
        <strong style="color:#17243b">Thanh toán đơn hàng</strong>
    </nav>

    <div class="checkout-heading">
        <h2>Xác Nhận &amp; Thanh Toán Đơn Hàng</h2>
        <a class="checkout-back" href="{{ url('/cart') }}">
            <i class="bi bi-arrow-left"></i> Quay lại giỏ hàng
        </a>
    </div>

    <form id="checkout-order-form" method="POST" action="{{ url('/checkout') }}">
        @csrf

        <div class="checkout-layout">

            {{-- CỘT TRÁI --}}
            <div class="checkout-left">

                {{-- 1. Thông tin người nhận --}}
                <section class="checkout-card">
                    <div class="checkout-card-title">
                        <span class="checkout-step">1</span>
                        Thông tin người nhận hàng
                    </div>

                    <div class="checkout-form-grid">
                        <div class="checkout-field">
                            <label>Họ và tên người nhận <span class="checkout-required">*</span></label>
                            <input
                                type="text"
                                name="receiver_name"
                                value="{{ $user['name'] ?? '' }}"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div class="checkout-field">
                            <label>Số điện thoại liên hệ <span class="checkout-required">*</span></label>
                            <input
                                type="tel"
                                name="receiver_phone"
                                value="{{ $user['phone'] ?? '' }}"
                                autocomplete="tel"
                                required
                            >
                        </div>

                        <div class="checkout-field full">
                            <label>Email nhận hóa đơn điện tử (VAT)</label>
                            <input
                                type="email"
                                name="receiver_email"
                                value="{{ $user['email'] ?? '' }}"
                                autocomplete="email"
                            >
                        </div>

                        <div class="checkout-field third">
                            <label>Tỉnh / Thành phố <span class="checkout-required">*</span></label>
                            <select name="city" required>
                                <option value="TP. Hồ Chí Minh" selected>TP. Hồ Chí Minh</option>
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Hải Phòng">Hải Phòng</option>
                                <option value="Cần Thơ">Cần Thơ</option>
                            </select>
                        </div>

                        <div class="checkout-field third">
                            <label>Quận / Huyện <span class="checkout-required">*</span></label>
                            <select name="district" required>
                                <option value="Quận 1" selected>Quận 1</option>
                                <option value="Quận 3">Quận 3</option>
                                <option value="Quận 5">Quận 5</option>
                                <option value="Quận Bình Thạnh">Quận Bình Thạnh</option>
                                <option value="Quận Tân Bình">Quận Tân Bình</option>
                            </select>
                        </div>

                        <div class="checkout-field third">
                            <label>Phường / Xã <span class="checkout-required">*</span></label>
                            <select name="ward" required>
                                <option value="Phường Bến Nghé" selected>Phường Bến Nghé</option>
                                <option value="Phường Bến Thành">Phường Bến Thành</option>
                                <option value="Phường Đa Kao">Phường Đa Kao</option>
                            </select>
                        </div>

                        <div class="checkout-field full">
                            <label>Địa chỉ số nhà, tên đường cụ thể <span class="checkout-required">*</span></label>
                            <input
                                type="text"
                                name="address"
                                value="Số 45, Đường Lê Duẩn"
                                autocomplete="street-address"
                                required
                            >
                        </div>

                        <div class="checkout-field full">
                            <label>Ghi chú giao hàng (Tùy chọn)</label>
                            <input
                                type="text"
                                name="note"
                                placeholder="Gọi trước 15 phút khi giao"
                            >
                        </div>
                    </div>
                </section>

                {{-- 2. Phương thức thanh toán --}}
                <section class="checkout-card">
                    <div class="checkout-card-title">
                        <span class="checkout-step">2</span>
                        Phương thức thanh toán
                    </div>

                    <div class="checkout-payment-list">

                        {{-- VietQR --}}
                        <label class="checkout-payment-option selected">
                            <input
                                type="radio"
                                name="payment_method"
                                value="vietqr"
                                checked
                            >

                            <span class="checkout-payment-icon" style="color:#1760ff">
                                <i class="bi bi-qr-code"></i>
                            </span>

                            <div class="checkout-payment-content">
                                <div class="checkout-payment-name">
                                    Chuyển khoản VietQR Siêu Tốc (Khuyên dùng)
                                    <span class="checkout-fast-badge">Tự động duyệt 24/7</span>
                                </div>

                                <div class="checkout-payment-desc">
                                    Mở app ngân hàng bất kỳ (MB, VCB, Techcombank, VPBank...)
                                    quét mã QR để thanh toán ngay lập tức.
                                </div>

                                <div class="checkout-qr-panel">
                                    <div class="checkout-qr-placeholder" aria-label="Biểu tượng QR">
                                        <i class="bi bi-qr-code"></i>
                                    </div>

                                    <div class="checkout-qr-info">
                                        <div><strong>Ngân hàng:</strong> MB Bank (Quân Đội)</div>
                                        <div><strong>Số tài khoản:</strong> 8888 6888 9999</div>
                                        <div><strong>Chủ tài khoản:</strong> CTY TNHH ELECTROTECH VIETNAM</div>
                                        <div>
                                            <strong>Số tiền:</strong>
                                            <span class="checkout-amount">
                                                {{ number_format($total ?? 0, 0, ',', '.') }}₫
                                            </span>
                                        </div>
                                        <div>
                                            <strong>Nội dung CK:</strong>
                                            <span style="background:#edf2f8;padding:2px 5px;border-radius:4px">
                                                TECH 678
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>

                        {{-- COD --}}
                        <label class="checkout-payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="cod"
                            >

                            <span class="checkout-payment-icon" style="color:#f08b26">
                                <i class="bi bi-truck"></i>
                            </span>

                            <div class="checkout-payment-content">
                                <div class="checkout-payment-name">
                                    Thanh toán khi nhận hàng (COD)
                                </div>
                                <div class="checkout-payment-desc">
                                    Nhận hàng tại nhà, kiểm tra niêm phong máy trước khi
                                    thanh toán tiền mặt cho nhân viên giao hàng.
                                </div>
                            </div>
                        </label>

                        {{-- Thẻ ngân hàng --}}
                        <label class="checkout-payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="credit_card"
                            >

                            <span class="checkout-payment-icon" style="color:#8b5cf6">
                                <i class="bi bi-credit-card"></i>
                            </span>

                            <div class="checkout-payment-content">
                                <div class="checkout-payment-name">
                                    Thẻ tín dụng / Ghi nợ quốc tế (Visa, Mastercard, JCB)
                                </div>
                                <div class="checkout-payment-desc">
                                    Cổng thanh toán bảo mật PCI-DSS, hỗ trợ trả góp 0%
                                    lãi suất các ngân hàng liên kết.
                                </div>
                            </div>
                        </label>

                        {{-- MoMo --}}
                        <label class="checkout-payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="momo"
                            >

                            <span class="checkout-payment-icon" style="color:#d946a8">
                                <i class="bi bi-phone"></i>
                            </span>

                            <div class="checkout-payment-content">
                                <div class="checkout-payment-name">
                                    Ví điện tử MoMo
                                </div>
                                <div class="checkout-payment-desc">
                                    Liên kết tài khoản ví MoMo để quét mã và xác nhận
                                    thanh toán an toàn trong vài giây.
                                </div>
                            </div>
                        </label>

                    </div>

                    <div class="checkout-vat">
                        <input type="checkbox" name="request_vat" id="request-vat" value="1">
                        <label for="request-vat">
                            Yêu cầu xuất hóa đơn giá trị gia tăng (VAT) cho doanh nghiệp
                        </label>
                    </div>
                </section>
            </div>

            {{-- CỘT PHẢI --}}
            <aside class="checkout-right">

                {{-- Tóm tắt đơn hàng --}}
                <section class="checkout-card">
                    <div class="checkout-summary-title">
                        KIỂM TRA GIỎ HÀNG
                        ({{ count($cart['items'] ?? []) }} MẶT HÀNG)
                    </div>

                    <div>
                        @forelse(($cart['items'] ?? []) as $item)
                            <div class="checkout-product">
                                <img
                                    src="{{ $item['image'] ?? '' }}"
                                    alt="{{ $item['name'] ?? 'Sản phẩm' }}"
                                >

                                <div class="checkout-product-info">
                                    <div class="checkout-product-name">
                                        {{ $item['name'] ?? 'Sản phẩm' }}
                                    </div>
                                    <div class="checkout-product-meta">
                                        Màu sắc / Phiên bản · SL: {{ $item['quantity'] ?? 1 }}
                                    </div>
                                </div>

                                <div class="checkout-product-price">
                                    {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}₫
                                </div>
                            </div>
                        @empty
                            <div style="padding:12px 0;color:#8090a8">
                                Giỏ hàng hiện chưa có sản phẩm.
                                <a href="{{ url('/cart') }}">Quay lại giỏ hàng</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="checkout-cost-row">
                        <span>Tạm tính tiền hàng:</span>
                        <strong>{{ number_format($subtotal ?? 0, 0, ',', '.') }}₫</strong>
                    </div>

                    <div class="checkout-cost-row">
                        <span>Phí vận chuyển tốc hành:</span>
                        <strong class="free">Miễn phí giao hàng</strong>
                    </div>

                    <div class="checkout-cost-row">
                        <span>Mã giảm (TECH500):</span>
                        <strong class="discount">
                            -{{ number_format($discount ?? 0, 0, ',', '.') }}₫
                        </strong>
                    </div>

                    <div class="checkout-total">
                        <div class="checkout-total-label">Tổng thanh toán:</div>
                        <div class="checkout-total-value">
                            {{ number_format($total ?? 0, 0, ',', '.') }}₫
                        </div>
                    </div>

                    <button type="submit" class="checkout-submit">
                        <i class="bi bi-lock"></i>
                        Xác Nhận Đặt Hàng Ngay
                    </button>

                    <div class="checkout-terms">
                        Bằng việc bấm xác nhận, bạn đồng ý với
                        <a href="#">Điều khoản mua sắm</a> và
                        <a href="#">Chính sách đổi trả hàng</a> của ElectroTech.
                    </div>
                </section>

                {{-- Hỗ trợ đặt hàng --}}
                <section class="checkout-support">
                    <div class="checkout-support-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>

                    <div>
                        <div class="checkout-support-title">
                            Hỗ trợ đặt hàng trực tuyến
                        </div>
                        <p>
                            Nếu bạn cần hỗ trợ xuất hóa đơn công ty hoặc tư vấn thêm
                            về phương thức trả góp, vui lòng liên hệ tổng đài
                            <strong>1800.6868</strong> (miễn cước).
                        </p>
                    </div>
                </section>

            </aside>
        </div>
    </form>
</div>
@endsection
