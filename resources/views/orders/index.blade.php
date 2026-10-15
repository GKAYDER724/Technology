@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng | ElectroTech Vietnam')

@section('content')
@php
    /*
    |--------------------------------------------------------------------------
    | Dữ liệu đơn hàng mẫu - Chưa cần Database
    |--------------------------------------------------------------------------
    */

    $orders = [
        [
            'id' => 'ORD-202610-891',
            'date' => '08/10/2026 14:30',
            'status' => 'shipping',
            'status_text' => 'Đang giao hàng',
            'payment' => 'VietQR',
            'total' => 8680000,
            'can_cancel' => false,
            'can_review' => false,
            'items' => [
                [
                    'name' => 'Tai nghe Chống Ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio',
                    'variant' => 'Màu Đen Tinh Tế',
                    'quantity' => 1,
                    'price' => 6990000,
                    'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=160&q=80',
                ],
                [
                    'name' => 'Chuột không dây Logitech MX Master 3S For Mac / Windows',
                    'variant' => 'Màu Graphite (Xám đậm)',
                    'quantity' => 1,
                    'price' => 2190000,
                    'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=160&q=80',
                ],
            ],
        ],
        [
            'id' => 'ORD-202609-342',
            'date' => '28/09/2026 09:15',
            'status' => 'completed',
            'status_text' => 'Đã giao thành công',
            'payment' => 'Thẻ/Ví',
            'total' => 32490000,
            'can_cancel' => false,
            'can_review' => true,
            'items' => [
                [
                    'name' => 'iPhone 16 Pro Max 256GB Chính Hãng VN/A',
                    'variant' => '256GB - Titan Sa Mạc',
                    'quantity' => 1,
                    'price' => 33490000,
                    'image' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=160&q=80',
                ],
            ],
        ],
        [
            'id' => 'ORD-202610-105',
            'date' => '09/10/2026 20:00',
            'status' => 'pending',
            'status_text' => 'Chờ xác nhận',
            'payment' => 'COD',
            'total' => 4420000,
            'can_cancel' => true,
            'can_review' => false,
            'items' => [
                [
                    'name' => 'Bàn phím cơ Custom Keychron Q1 Pro QMK/VIA Wireless',
                    'variant' => 'Carbon Black - Red Switch',
                    'quantity' => 1,
                    'price' => 4390000,
                    'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=160&q=80',
                ],
            ],
        ],
    ];

    $statusTabs = [
        'all' => 'Tất cả đơn',
        'pending' => 'Chờ xác nhận',
        'processing' => 'Đang xử lý',
        'shipping' => 'Đang giao hàng',
        'completed' => 'Đã giao thành công',
        'cancelled' => 'Đã hủy',
    ];

    $currentStatus = request('status', 'all');
    $searchOrder = trim(request('search', ''));

    $filteredOrders = collect($orders)->filter(function ($order) use (
        $currentStatus,
        $searchOrder
    ) {
        if (
            $currentStatus !== 'all' &&
            $order['status'] !== $currentStatus
        ) {
            return false;
        }

        if (
            $searchOrder !== '' &&
            !str_contains(
                mb_strtolower($order['id']),
                mb_strtolower($searchOrder)
            )
        ) {
            return false;
        }

        return true;
    })->values();

    $formatPrice = function ($price) {
        return number_format($price, 0, ',', '.') . '₫';
    };
@endphp

<div class="orders-page">

    {{-- Breadcrumb --}}
    <nav class="orders-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <i class="bi bi-chevron-right"></i>
        <span>Lịch sử đơn hàng</span>
    </nav>

    {{-- Tiêu đề và thanh trạng thái --}}
    <section class="orders-heading">

        <div class="orders-heading-top">
            <div class="orders-heading-content">
                <h1>Quản Lý &amp; Lịch Sử Đơn Hàng</h1>

                <p>
                    Theo dõi tình trạng đơn, tra cứu vận chuyển
                    và gửi yêu cầu hủy đơn thuận tiện
                </p>
            </div>

            <form
                action="{{ url('/orders') }}"
                method="GET"
                class="orders-search"
            >
                <input
                    type="hidden"
                    name="status"
                    value="{{ $currentStatus }}"
                >

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $searchOrder }}"
                    placeholder="Tìm theo mã đơn (ORD-...)"
                    aria-label="Tìm theo mã đơn hàng"
                >

                <button type="submit" aria-label="Tìm kiếm">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>
        </div>

        <div class="orders-tabs">
            @foreach($statusTabs as $key => $label)
                <a
                    href="{{ url('/orders') }}?{{ http_build_query(array_filter([
                        'status' => $key,
                        'search' => $searchOrder,
                    ], fn($value) => $value !== '')) }}"
                    class="orders-tab {{ $currentStatus === $key ? 'active' : '' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

    </section>

    {{-- Danh sách đơn hàng --}}
    <section class="orders-list">

        @forelse($filteredOrders as $order)

            <article class="order-card">

                {{-- Mã đơn và trạng thái --}}
                <header class="order-card-header">

                    <div class="order-header-info">
                        <a
                            href="{{ url('/orders/' . $order['id']) }}"
                            class="order-code"
                        >
                            #{{ $order['id'] }}
                        </a>

                        <span class="order-date">
                            Đặt lúc: {{ $order['date'] }}
                        </span>
                    </div>

                    @php
                        $statusClass = match ($order['status']) {
                            'pending' => 'status-pending',
                            'processing' => 'status-processing',
                            'shipping' => 'status-shipping',
                            'completed' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                            default => '',
                        };

                        $statusIcon = match ($order['status']) {
                            'pending' => 'bi-clock',
                            'processing' => 'bi-arrow-repeat',
                            'shipping' => 'bi-truck',
                            'completed' => 'bi-check-circle',
                            'cancelled' => 'bi-x-circle',
                            default => 'bi-circle',
                        };
                    @endphp

                    <span class="order-status {{ $statusClass }}">
                        <i class="bi {{ $statusIcon }}"></i>
                        {{ $order['status_text'] }}
                    </span>

                </header>

                {{-- Các sản phẩm trong đơn --}}
                <div class="order-items">

                    @foreach($order['items'] as $item)

                        <div class="order-item">

                            <div class="order-item-main">

                                <div class="order-item-image">
                                    <img
                                        src="{{ $item['image'] }}"
                                        alt="{{ $item['name'] }}"
                                        loading="lazy"
                                    >
                                </div>

                                <div class="order-item-info">
                                    <a
                                        href="{{ url('/orders/' . $order['id']) }}"
                                        class="order-item-name"
                                    >
                                        {{ $item['name'] }}
                                    </a>

                                    <p class="order-item-variant">
                                        {{ $item['variant'] }}
                                        · Số lượng: {{ $item['quantity'] }}
                                    </p>
                                </div>

                            </div>

                            <div class="order-item-price">
                                {{ $formatPrice($item['price'] * $item['quantity']) }}

                                @if($order['can_review'])
                                    <a
                                        href="{{ url('/orders/' . $order['id'] . '/review') }}"
                                        class="order-review-link"
                                    >
                                        <i class="bi bi-star-fill"></i>
                                        Đánh giá
                                    </a>
                                @endif
                            </div>

                        </div>

                    @endforeach

                </div>

                {{-- Tổng tiền và nút thao tác --}}
                <footer class="order-card-footer">

                    <div class="order-total">
                        <span>Tổng thanh toán:</span>

                        <strong>
                            {{ $formatPrice($order['total']) }}
                        </strong>

                        <small>({{ $order['payment'] }})</small>
                    </div>

                    <div class="order-actions">

                        @if($order['can_cancel'])
                            <button
                                type="button"
                                class="order-cancel-btn"
                                onclick="alert('Yêu cầu hủy đơn hàng {{ $order['id'] }}')"
                            >
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Yêu cầu hủy đơn
                            </button>
                        @endif

                        <a
                            href="{{ url('/orders/' . $order['id']) }}"
                            class="order-detail-btn"
                        >
                            <i class="bi bi-eye"></i>
                            Xem chi tiết
                        </a>

                    </div>

                </footer>

            </article>

        @empty

            <div class="orders-empty">
                <div class="orders-empty-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <h2>Không tìm thấy đơn hàng</h2>

                <p>
                    Không có đơn hàng phù hợp với thông tin bạn tìm kiếm.
                </p>

                <a href="{{ url('/orders') }}">
                    Xem tất cả đơn hàng
                </a>
            </div>

        @endforelse

    </section>

</div>
@endsection
