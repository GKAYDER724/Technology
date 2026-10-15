
@extends('layouts.app')

@section('title', 'Trung tâm thông báo - ElectroTech')

@section('content')
<main class="et-notification-page">
    <div class="et-notification-container">

        {{-- BREADCRUMB --}}
        <nav class="et-notification-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <span>Trung tâm thông báo</span>
        </nav>

        {{-- PAGE HEADER --}}
        <section class="et-notification-header">
            <div class="et-notification-heading">
                <div class="et-notification-heading-icon">
                    <i class="bi bi-bell"></i>
                </div>

                <div>
                    <h1>Thông Báo Của Bạn</h1>
                    <p>Cập nhật trạng thái đơn hàng, ưu đãi và hoạt động tài khoản</p>
                </div>
            </div>

            <button
                type="button"
                class="et-notification-read-all"
                id="etMarkAllRead"
            >
                <i class="bi bi-check2-all"></i>
                Đánh dấu tất cả đã đọc
            </button>

            <div class="et-notification-tabs" role="tablist">
                <button
                    type="button"
                    class="et-notification-tab active"
                    data-filter="all"
                    role="tab"
                    aria-selected="true"
                >
                    Tất cả
                </button>

                <button
                    type="button"
                    class="et-notification-tab"
                    data-filter="order"
                    role="tab"
                    aria-selected="false"
                >
                    Cập nhật đơn hàng
                </button>

                <button
                    type="button"
                    class="et-notification-tab"
                    data-filter="promotion"
                    role="tab"
                    aria-selected="false"
                >
                    Khuyến mãi &amp; Điểm thưởng
                </button>

                <button
                    type="button"
                    class="et-notification-tab"
                    data-filter="system"
                    role="tab"
                    aria-selected="false"
                >
                    Thông báo hệ thống
                </button>
            </div>
        </section>

        {{-- NOTIFICATION LIST --}}
        <section
            class="et-notification-list"
            id="etNotificationList"
            aria-label="Danh sách thông báo"
        >

            {{-- 1. ORDER SHIPPING --}}
            <article
                class="et-notification-item unread"
                data-category="order"
            >
                <div class="et-notification-icon order-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="et-notification-content">
                    <div class="et-notification-title-row">
                        <h2>Đơn hàng ORD-202610-891 đang trên đường giao</h2>
                        <time datetime="2026-10-11T08:30">
                            Hôm nay lúc 08:30
                        </time>
                    </div>

                    <p>
                        Bưu tá Viettel Post đang trên đường giao đơn hàng gồm
                        Tai nghe Sony WH-1000XM5 và Chuột Logitech MX Master 3S.
                        Vui lòng để ý điện thoại!
                    </p>

                    <a
                        href="{{ url('/orders/ORD-202610-891') }}"
                        class="et-notification-detail"
                    >
                        Xem chi tiết đơn hàng #ORD-202610-891
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

                <span class="et-notification-unread-dot"
                      aria-label="Chưa đọc"></span>
            </article>

            {{-- 2. PROMOTION --}}
            <article
                class="et-notification-item unread"
                data-category="promotion"
            >
                <div class="et-notification-icon promotion-icon">
                    <i class="bi bi-tag"></i>
                </div>

                <div class="et-notification-content">
                    <div class="et-notification-title-row">
                        <h2>Flash Sale Cuối Tuần: Giảm tới 30% Phụ Kiện</h2>
                        <time datetime="2026-10-11T19:00">
                            Hôm qua lúc 19:00
                        </time>
                    </div>

                    <p>
                        Nhập mã TECH500 để được giảm ngay 500.000đ cho đơn từ
                        5.000.000đ. Ưu đãi chỉ áp dụng trong 48 giờ.
                    </p>
                </div>

                <span class="et-notification-unread-dot"
                      aria-label="Chưa đọc"></span>
            </article>

            {{-- 3. ORDER COMPLETED --}}
            <article
                class="et-notification-item"
                data-category="order"
            >
                <div class="et-notification-icon order-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="et-notification-content">
                    <div class="et-notification-title-row">
                        <h2>Đơn hàng ORD-202609-342 giao thành công</h2>
                        <time datetime="2026-09-28T15:50">
                            28/09 lúc 15:50
                        </time>
                    </div>

                    <p>
                        Bạn đã nhận thành công iPhone 16 Pro Max 256GB.
                        Hãy để lại đánh giá để nhận 100 điểm thưởng TechMember!
                    </p>

                    <a
                        href="{{ url('/orders/ORD-202609-342') }}"
                        class="et-notification-detail"
                    >
                        Xem chi tiết đơn hàng #ORD-202609-342
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </article>

            {{-- 4. VIP SYSTEM --}}
            <article
                class="et-notification-item"
                data-category="system"
            >
                <div class="et-notification-icon system-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div class="et-notification-content">
                    <div class="et-notification-title-row">
                        <h2>Nâng hạng hội viên Tech VIP thành công</h2>
                        <time datetime="2026-09-25T10:00">
                            25/09 lúc 10:00
                        </time>
                    </div>

                    <p>
                        Chúc mừng bạn đã đạt hạn mức chi tiêu tích lũy trên
                        50 triệu và trở thành Tech VIP với đặc quyền miễn phí
                        giao hàng trọn đời.
                    </p>
                </div>
            </article>

            {{-- EMPTY STATE --}}
            <div class="et-notification-empty" id="etNotificationEmpty" hidden>
                <div class="et-notification-empty-icon">
                    <i class="bi bi-bell-slash"></i>
                </div>
                <h2>Không có thông báo</h2>
                <p>Hiện chưa có thông báo nào thuộc danh mục này.</p>
            </div>
        </section>

    </div>
</main>
@endsection
