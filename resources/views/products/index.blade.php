
@extends('layouts.app')

@section('title', 'Tất cả sản phẩm | ElectroTech Vietnam')

@section('content')
@php
    $products = [
        [
            'id' => 1,
            'brand' => 'APPLE',
            'name' => 'iPhone 16 Pro Max 256GB Chính Hãng VN/A',
            'price' => 33490000,
            'old_price' => 35990000,
            'discount' => 7,
            'rating' => '4.9',
            'reviews' => 147,
            'stock' => 24,
            'badge' => 'Bán chạy',
            'image' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=85',
            'description' => 'Khung Titan cao cấp, Chip Apple A18 Pro mạnh mẽ, Camera Control điều khiển chụp chuyên nghiệp.'
        ],
        [
            'id' => 2,
            'brand' => 'APPLE',
            'name' => 'MacBook Pro 14 M3 Pro (18GB / 512GB SSD) Space Black',
            'price' => 46990000,
            'old_price' => 49990000,
            'discount' => 6,
            'rating' => '5.0',
            'reviews' => 85,
            'stock' => 12,
            'badge' => 'Bán chạy',
            'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=85',
            'description' => 'Chip M3 Pro, màn hình Liquid Retina XDR, hiệu năng cao cho công việc chuyên nghiệp.'
        ],
        [
            'id' => 3,
            'brand' => 'SAMSUNG',
            'name' => 'Samsung Galaxy S24 Ultra 5G 12GB/256GB - AI Phone',
            'price' => 27990000,
            'old_price' => 29990000,
            'discount' => 6,
            'rating' => '4.8',
            'reviews' => 96,
            'stock' => 18,
            'badge' => '',
            'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&w=600&q=85',
            'description' => 'Điện thoại Galaxy AI, khung viền Titanium cùng bút S Pen tích hợp.'
        ],
        [
            'id' => 4,
            'brand' => 'ASUS',
            'name' => 'Laptop Gaming ASUS ROG Zephyrus G16 (Core Ultra 9 / RTX 4070)',
            'price' => 54990000,
            'old_price' => 59990000,
            'discount' => 7,
            'rating' => '4.9',
            'reviews' => 92,
            'stock' => 7,
            'badge' => 'Bán chạy',
            'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=600&q=85',
            'description' => 'Laptop gaming mạnh mẽ, màn hình chất lượng cao, thiết kế hiện đại.'
        ],
        [
            'id' => 5,
            'brand' => 'SONY',
            'name' => 'Tai nghe Chống Ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio',
            'price' => 6990000,
            'old_price' => 8690000,
            'discount' => 20,
            'rating' => '4.9',
            'reviews' => 123,
            'stock' => 35,
            'badge' => '',
            'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=85',
            'description' => 'Công nghệ chống ồn chủ động, âm thanh chất lượng cao, đeo thoải mái.'
        ],
        [
            'id' => 6,
            'brand' => 'APPLE',
            'name' => 'Apple Watch Ultra 2 GPS + Cellular 49mm Dây Alpine Loop',
            'price' => 19990000,
            'old_price' => 21990000,
            'discount' => 9,
            'rating' => '4.9',
            'reviews' => 56,
            'stock' => 9,
            'badge' => '',
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=85',
            'description' => 'Thiết kế bền bỉ, màn hình sáng, hỗ trợ theo dõi sức khỏe và luyện tập.'
        ],
        [
            'id' => 7,
            'brand' => 'APPLE',
            'name' => 'iPad Pro 11 inch M4 Wi-Fi 256GB - Siêu Mỏng Nhẹ',
            'price' => 26490000,
            'old_price' => 28990000,
            'discount' => 8,
            'rating' => '4.9',
            'reviews' => 47,
            'stock' => 14,
            'badge' => '',
            'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=85',
            'description' => 'Màn hình sắc nét, thiết kế siêu mỏng, phù hợp học tập và sáng tạo.'
        ],
        [
            'id' => 8,
            'brand' => 'KEYCHRON',
            'name' => 'Bàn phím cơ Custom Keychron Q1 Pro QMK/VIA Wireless',
            'price' => 4390000,
            'old_price' => 4890000,
            'discount' => 10,
            'rating' => '4.8',
            'reviews' => 78,
            'stock' => 22,
            'badge' => 'Bán chạy',
            'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=85',
            'description' => 'Bàn phím cơ cao cấp, kết nối không dây, thiết kế tối ưu cho góc làm việc.'
        ],
        [
            'id' => 9,
            'brand' => 'MARSHALL',
            'name' => 'Loa Bluetooth Marshall Stanmore III Chính Hãng ASH',
            'price' => 8990000,
            'old_price' => 10490000,
            'discount' => 14,
            'rating' => '4.9',
            'reviews' => 112,
            'stock' => 16,
            'badge' => '',
            'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=600&q=85',
            'description' => 'Âm thanh mạnh mẽ, thiết kế cổ điển, phù hợp nghe nhạc trong không gian sống.'
        ],
        [
            'id' => 10,
            'brand' => 'LOGITECH',
            'name' => 'Chuột không dây Logitech MX Master 3S For Mac / Windows',
            'price' => 2190000,
            'old_price' => 2590000,
            'discount' => 15,
            'rating' => '4.9',
            'reviews' => 310,
            'stock' => 45,
            'badge' => '',
            'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=600&q=85',
            'description' => 'Chuột công thái học, thao tác chính xác, phù hợp làm việc và thiết kế.'
        ],
    ];

    $brands = ['Apple', 'Samsung', 'Sony', 'Asus', 'Dell', 'Marshall', 'Keychron', 'Logitech'];

    $categories = [
        'Tất cả sản phẩm',
        'Điện thoại di động',
        'Laptop & Máy tính',
        'Máy tính bảng iPad',
        'Tai nghe & Loa',
        'Đồng hồ thông minh',
        'Phụ kiện công nghệ',
    ];

    $priceRanges = [
        'all' => 'Tất cả mức giá',
        'under5' => 'Dưới 5 triệu',
        '5to15' => 'Từ 5 - 15 triệu',
        '15to30' => 'Từ 15 - 30 triệu',
        'over30' => 'Trên 30 triệu',
    ];

    $selectedBrand = request('brand', '');
    $selectedPrice = request('price', 'all');
    $selectedCategory = request('category', 'all');
    $search = request('search', '');
    $inStockOnly = request()->boolean('in_stock');
    $sort = request('sort', 'popular');

    $filteredProducts = collect($products)->filter(function ($product) use (
        $selectedBrand, $selectedPrice, $selectedCategory, $search, $inStockOnly
    ) {
        if ($selectedBrand && strtolower($product['brand']) !== strtolower($selectedBrand)) {
            return false;
        }

        if ($selectedPrice === 'under5' && $product['price'] >= 5000000) {
            return false;
        }

        if ($selectedPrice === '5to15' && ($product['price'] < 5000000 || $product['price'] > 15000000)) {
            return false;
        }

        if ($selectedPrice === '15to30' && ($product['price'] < 15000000 || $product['price'] > 30000000)) {
            return false;
        }

        if ($selectedPrice === 'over30' && $product['price'] <= 30000000) {
            return false;
        }

        if ($inStockOnly && $product['stock'] <= 0) {
            return false;
        }

        if ($search && !str_contains(
            mb_strtolower($product['name'] . ' ' . $product['brand']),
            mb_strtolower($search)
        )) {
            return false;
        }

        if ($selectedCategory !== 'all') {
            $categoryMap = [
                'phone' => ['iPhone', 'Samsung Galaxy'],
                'laptop' => ['MacBook', 'Laptop Gaming'],
                'tablet' => ['iPad'],
                'audio' => ['Tai nghe', 'Loa Bluetooth'],
                'watch' => ['Apple Watch'],
                'accessories' => ['Bàn phím', 'Chuột'],
            ];

            if (isset($categoryMap[$selectedCategory])) {
                $matches = false;

                foreach ($categoryMap[$selectedCategory] as $keyword) {
                    if (str_contains(mb_strtolower($product['name']), mb_strtolower($keyword))) {
                        $matches = true;
                        break;
                    }
                }

                if (!$matches) {
                    return false;
                }
            }
        }

        return true;
    });

    if ($sort === 'price_asc') {
        $filteredProducts = $filteredProducts->sortBy('price');
    } elseif ($sort === 'price_desc') {
        $filteredProducts = $filteredProducts->sortByDesc('price');
    } elseif ($sort === 'newest') {
        $filteredProducts = $filteredProducts->sortByDesc('id');
    } elseif ($sort === 'discount') {
        $filteredProducts = $filteredProducts->sortByDesc('discount');
    }

    $filteredProducts = $filteredProducts->values();
@endphp

<div class="catalog-page">
    {{-- Breadcrumb --}}
    <nav class="catalog-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <i class="bi bi-chevron-right"></i>
        <span>Tất cả sản phẩm</span>
    </nav>

    {{-- Page title --}}
    <section class="catalog-title-box">
        <div>
            <h1>Tất cả sản phẩm</h1>
            <p>Hiển thị <strong>{{ $filteredProducts->count() }}</strong> thiết bị điện tử chính hãng có sẵn</p>
        </div>

        <form class="catalog-search" method="GET" action="{{ url('/products') }}">
            @foreach(request()->except('search', 'page') as $key => $value)
                @if(is_scalar($value))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <i class="bi bi-search"></i>
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Tìm theo tên thiết bị, thương hiệu..."
                aria-label="Tìm sản phẩm"
            >
            <button type="submit" aria-label="Tìm kiếm">
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>
    </section>

    <div class="catalog-layout">
        {{-- Sidebar filters --}}
        <aside class="catalog-sidebar">
            <form method="GET" action="{{ url('/products') }}" id="catalog-filter-form">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="sort" value="{{ $sort }}">

                <div class="filter-header">
                    <h2><i class="bi bi-funnel"></i> Bộ lọc tìm kiếm</h2>
                    <a href="{{ url('/products') }}" class="filter-reset">
                        <i class="bi bi-arrow-counterclockwise"></i> Đặt lại
                    </a>
                </div>

                <div class="filter-section">
                    <h3>DANH MỤC THIẾT BỊ</h3>

                    @php
                        $categoryOptions = [
                            'all' => 'Tất cả sản phẩm',
                            'phone' => 'Điện thoại di động',
                            'laptop' => 'Laptop & Máy tính',
                            'tablet' => 'Máy tính bảng iPad',
                            'audio' => 'Tai nghe & Loa',
                            'watch' => 'Đồng hồ thông minh',
                            'accessories' => 'Phụ kiện công nghệ',
                        ];
                    @endphp

                    @foreach($categoryOptions as $value => $label)
                        <label class="filter-option {{ $selectedCategory === $value ? 'selected' : '' }}">
                            <input
                                type="radio"
                                name="category"
                                value="{{ $value }}"
                                {{ $selectedCategory === $value ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            >
                            <span>{{ $label }}</span>
                            @if($selectedCategory === $value)
                                <i class="bi bi-check2"></i>
                            @endif
                        </label>
                    @endforeach
                </div>

                <div class="filter-section">
                    <h3>THƯƠNG HIỆU</h3>

                    <div class="brand-chips">
                        <button
                            type="submit"
                            name="brand"
                            value=""
                            class="brand-chip {{ $selectedBrand === '' ? 'active' : '' }}"
                        >Tất cả</button>

                        @foreach($brands as $brand)
                            <button
                                type="submit"
                                name="brand"
                                value="{{ $brand }}"
                                class="brand-chip {{ strtolower($selectedBrand) === strtolower($brand) ? 'active' : '' }}"
                            >{{ $brand }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="filter-section">
                    <h3>KHOẢNG GIÁ</h3>

                    @foreach($priceRanges as $value => $label)
                        <label class="filter-option {{ $selectedPrice === $value ? 'selected' : '' }}">
                            <input
                                type="radio"
                                name="price"
                                value="{{ $value }}"
                                {{ $selectedPrice === $value ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            >
                            <span>{{ $label }}</span>
                            @if($selectedPrice === $value)
                                <i class="bi bi-check2"></i>
                            @endif
                        </label>
                    @endforeach
                </div>

                <div class="filter-stock">
                    <label>
                        <input
                            type="checkbox"
                            name="in_stock"
                            value="1"
                            {{ $inStockOnly ? 'checked' : '' }}
                            onchange="this.form.submit()"
                        >
                        <span>Chỉ hiện sản phẩm còn hàng</span>
                    </label>
                </div>
            </form>
        </aside>

        {{-- Product list --}}
        <section class="catalog-results">
            <div class="catalog-sortbar">
                <span class="sort-caption">
                    <i class="bi bi-sliders2"></i> Sắp xếp theo:
                </span>

                <div class="sort-options">
                    @php
                        $sortOptions = [
                            'popular' => 'Phổ biến',
                            'newest' => 'Bán chạy nhất',
                            'rating' => 'Đánh giá cao',
                            'price_asc' => 'Giá tăng dần',
                            'price_desc' => 'Giá giảm dần',
                        ];
                    @endphp

                    @foreach($sortOptions as $value => $label)
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => $value, 'page' => null]) }}"
                            class="sort-link {{ $sort === $value ? 'active' : '' }}"
                        >{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            @if($filteredProducts->isNotEmpty())
                <div class="catalog-product-grid">
                    @foreach($filteredProducts as $product)
                        <article class="catalog-product-card">
                            <a href="{{ url('/products/' . $product['id']) }}" class="catalog-product-image">
                                <img
                                    src="{{ $product['image'] }}"
                                    alt="{{ $product['name'] }}"
                                    loading="{{ $loop->index < 6 ? 'eager' : 'lazy' }}"
                                >

                                @if($product['discount'] > 0)
                                    <span class="catalog-discount">-{{ $product['discount'] }}%</span>
                                @endif

                                @if($product['badge'])
                                    <span class="catalog-bestseller">{{ $product['badge'] }}</span>
                                @endif
                            </a>

                            <div class="catalog-product-info">
                                <div class="catalog-product-meta">
                                    <span>{{ $product['brand'] }}</span>
                                    <span class="catalog-rating">
                                        <i class="bi bi-star-fill"></i>
                                        {{ $product['rating'] }}
                                        <small>({{ $product['reviews'] }})</small>
                                    </span>
                                </div>

                                <a href="{{ url('/products/' . $product['id']) }}" class="catalog-product-name">
                                    {{ $product['name'] }}
                                </a>

                                <p class="catalog-product-description">
                                    {{ $product['description'] }}
                                </p>

                                <div class="catalog-price-line">
                                    <strong>{{ number_format($product['price'], 0, ',', '.') }}₫</strong>
                                    <del>{{ number_format($product['old_price'], 0, ',', '.') }}₫</del>
                                </div>

                                <div class="catalog-product-actions">
                                    <span class="catalog-stock">
                                        <i class="bi bi-box-seam"></i>
                                        Còn {{ $product['stock'] }} máy
                                    </span>

                                    <div class="catalog-action-buttons">
                                        <a href="{{ url('/products/' . $product['id']) }}" class="catalog-detail-btn">
                                            Chi tiết
                                        </a>

                                        <form method="POST" action="{{ url('/cart/add/' . $product['id']) }}">
                                            @csrf
                                            <button type="submit" class="catalog-cart-btn" aria-label="Thêm vào giỏ hàng">
                                                <i class="bi bi-cart3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="catalog-empty">
                    <i class="bi bi-search"></i>
                    <h2>Không tìm thấy sản phẩm</h2>
                    <p>Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm của bạn.</p>
                    <a href="{{ url('/products') }}" class="catalog-empty-button">Xem tất cả sản phẩm</a>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
