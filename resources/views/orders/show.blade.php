
@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Hàng - ElectroTech')

@section('content')

<div class="order-detail-page">
    <div class="order-container">

        {{-- Breadcrumb --}}
        <nav class="breadcrumb-custom" aria-label="breadcrumb">
            <a href="/">Trang chủ</a>
            <span>›</span>
            <a href="{{ url('/orders') }}">Lịch sử đặt hàng</a>
            <span>›</span>
            <span class="current">Đơn hàng #ORD-202610-891</span>
        </nav>

        {{-- Order heading --}}
        <section class="order-card order-heading">
            <div>
                <h1 class="order-title">
                    Chi Tiết Đơn Hàng #ORD-202610-891
                    <span class="order-status">Đang giao hàng</span>
                </h1>

                <div class="order-date">
                    Thời gian đặt hàng:
                    <strong>08/10/2026 14:30</strong>
                </div>
            </div>

            <a href="{{ url('/orders') }}" class="btn-order-back">
                <i class="bi bi-arrow-left me-1"></i>
                Danh sách đơn hàng
            </a>
        </section>

        {{-- Shipping progress --}}
        <section class="order-card tracking-card">
            <div class="tracking-title">
                <h2 class="section-title">
                    <i class="bi bi-truck"></i>
                    Tiến trình vận chuyển đơn hàng
                </h2>
            </div>

            <ul class="tracking-list">
                <li class="tracking-step">
                    <span class="tracking-dot"></span>
                    <div>
                        <strong>Đặt hàng thành công</strong>
                        <span class="tracking-description">
                            Đơn hàng đã được tạo trên hệ thống
                        </span>
                    </div>
                    <span class="tracking-time">08/10 14:30</span>
                </li>

                <li class="tracking-step">
                    <span class="tracking-dot"></span>
                    <div>
                        <strong>Đã xác nhận thanh toán</strong>
                        <span class="tracking-description">
                            Giao dịch VietQR thành công
                        </span>
                    </div>
                    <span class="tracking-time">08/10 14:35</span>
                </li>

                <li class="tracking-step">
                    <span class="tracking-dot"></span>
                    <div>
                        <strong>Đã đóng gói hàng</strong>
                        <span class="tracking-description">
                            Kho Tân Bình hoàn tất kiểm tra và đóng kiện
                        </span>
                    </div>
                    <span class="tracking-time">08/10 16:00</span>
                </li>

                <li class="tracking-step">
                    <span class="tracking-dot"></span>
                    <div>
                        <strong>Đang vận chuyển</strong>
                        <span class="tracking-description">
                            Bưu tá Viettel Post đang trên đường giao hàng
                        </span>
                    </div>
                    <span class="tracking-time">09/10 08:30</span>
                </li>

                <li class="tracking-step pending">
                    <span class="tracking-dot"></span>
                    <div>
                        <strong>Giao hàng thành công</strong>
                        <span class="tracking-description">
                            Khách hàng ký nhận và nghiệm thu thiết bị
                        </span>
                    </div>
                    <span class="tracking-time">Dự kiến 10/10</span>
                </li>
            </ul>
        </section>

        {{-- Products and order information --}}
        <div class="bottom-grid">

            {{-- Left: products and total --}}
            <section class="order-card products-card">
                <div class="card-heading">
                    <h2 class="section-title">Sản phẩm trong đơn hàng (2)</h2>
                </div>

                {{-- Product 1 --}}
                <div class="product-row">
                    <img
                        src="https://placehold.co/100x100/ffdc48/161616?text=SONY"
                        alt="Tai nghe Sony"
                        class="product-image"
                    >

                    <div class="product-information">
                        <span class="product-name">
                            Tai nghe Chống ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio
                        </span>
                        <div class="product-meta">Phân loại: Màu Đen Tinh Tế</div>
                        <div class="product-meta">Đơn giá: 6.990.000₫ × 1</div>
                    </div>

                    <div class="product-price">6.990.000₫</div>
                </div>

                {{-- Product 2 --}}
                <div class="product-row">
                    <img
                        src="https://placehold.co/100x100/222222/ffffff?text=LOGI"
                        alt="Chuột Logitech"
                        class="product-image"
                    >

                    <div class="product-information">
                        <span class="product-name">
                            Chuột không dây Logitech MX Master 3S For Mac / Windows
                        </span>
                        <div class="product-meta">Phân loại: Màu Graphite (Xám đậm)</div>
                        <div class="product-meta">Đơn giá: 2.190.000₫ × 1</div>
                    </div>

                    <div class="product-price">2.190.000₫</div>
                </div>

                {{-- Cost breakdown --}}
                <div class="order-costs">
                    <div class="cost-line">
                        <span>Tạm tính tiền hàng:</span>
                        <strong>9.180.000₫</strong>
                    </div>

                    <div class="cost-line">
                        <span>Phí vận chuyển:</span>
                        <strong>Miễn phí</strong>
                    </div>

                    <div class="cost-line discount">
                        <span>Voucher giảm giá (TECH500):</span>
                        <strong>-500.000₫</strong>
                    </div>
                </div>

                <div class="total-line">
                    <span class="total-label">Tổng thanh toán:</span>
                    <span class="total-price">8.680.000₫</span>
                </div>
            </section>

            {{-- Right: shipping and payment --}}
            <aside class="right-column">

                {{-- Shipping address --}}
                <section class="order-card side-card">
                    <div class="card-heading">
                        <h2 class="section-title">
                            <i class="bi bi-geo-alt"></i>
                            Địa chỉ giao hàng
                        </h2>
                    </div>

                    <div class="receiver-name">Nguyễn Văn Hùng</div>

                    <div class="receiver-phone">
                        <i class="bi bi-telephone"></i>
                        0912 345 678
                    </div>

                    <div class="receiver-address">
                        Số 45, Đường Lê Duẩn, Phường Bến Nghé,
                        Quận 1, TP. Hồ Chí Minh
                    </div>

                    <div class="delivery-note">
                        <strong>Ghi chú:</strong>
                        Giao giờ hành chính, gọi trước 15 phút khi đến
                    </div>
                </section>

                {{-- Payment method --}}
                <section class="order-card side-card">
                    <div class="card-heading">
                        <h2 class="section-title">
                            <i class="bi bi-credit-card"></i>
                            Phương thức thanh toán
                        </h2>
                    </div>

                    <div class="payment-line">
                        <span class="payment-label">Hình thức:</span>
                        <span class="payment-value">CHUYỂN KHOẢN VIETQR</span>
                    </div>

                    <div class="payment-line">
                        <span class="payment-label">Trạng thái tiền:</span>
                        <span class="paid-badge">Đã thanh toán</span>
                    </div>
                </section>

                {{-- Warranty --}}
                <section class="order-card side-card warranty-card">
                    <div class="warranty-title">
                        <i class="bi bi-shield-check"></i>
                        Bảo hành chính hãng ElectroCare
                    </div>

                    <p class="warranty-text">
                        Tất cả sản phẩm trong đơn được bảo hành điện tử
                        theo số điện thoại đặt hàng 0912 345 678.
                    </p>
                </section>

            </aside>
        </div>

    </div>
</div>

@endsection
