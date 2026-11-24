@extends('layouts.app')

@section('title', 'Tất cả sản phẩm | ElectroTech Vietnam')

@section('content')

    <div class="catalog-page">

        {{-- BREADCRUMB --}}
        <nav class="catalog-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <span>Tất cả sản phẩm</span>
        </nav>

        {{-- TIÊU ĐỀ VÀ TÌM KIẾM --}}
        <section class="catalog-title-box">
            <div>
                <h1>Tất cả sản phẩm</h1>
                <p>
                    Hiển thị
                    <strong>{{ $products->total() }}</strong>
                    thiết bị điện tử chính hãng
                </p>
            </div>

            <form class="catalog-search" method="GET" action="{{ url('/products') }}">
                <input type="hidden" name="category" value="{{ $selectedCategory }}">

                <input type="hidden" name="price" value="{{ $selectedPrice }}">

                <input type="hidden" name="sort" value="{{ $sort }}">

                @if ($inStockOnly)
                    <input type="hidden" name="in_stock" value="1">
                @endif

                <i class="bi bi-search"></i>

                <input type="text" name="search" value="{{ $search }}" placeholder="Tìm theo tên sản phẩm..."
                    aria-label="Tìm sản phẩm">

                <button type="submit" aria-label="Tìm kiếm">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>
        </section>

        {{-- DANH SÁCH VÀ BỘ LỌC --}}
        <div class="catalog-layout">

            {{-- SIDEBAR BỘ LỌC --}}
            <aside class="catalog-sidebar">

                <form method="GET" action="{{ url('/products') }}" id="catalog-filter-form">

                    <input type="hidden" name="search" value="{{ $search }}">

                    <input type="hidden" name="sort" value="{{ $sort }}">

                    {{-- TIÊU ĐỀ BỘ LỌC --}}
                    <div class="filter-header">
                        <h2>
                            <i class="bi bi-funnel"></i>
                            Bộ lọc tìm kiếm
                        </h2>

                        <a href="{{ url('/products') }}" class="filter-reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Đặt lại
                        </a>
                    </div>

                    {{-- DANH MỤC CHA - CON --}}
                    <div class="filter-section">

                        <h3>DANH MỤC THIẾT BỊ</h3>

                        {{-- TẤT CẢ SẢN PHẨM --}}
                        <label class="filter-option {{ $selectedCategory === 'all' ? 'selected' : '' }}">

                            <input type="radio" name="category" value="all"
                                {{ $selectedCategory === 'all' ? 'checked' : '' }} onchange="this.form.submit()">

                            <span>Tất cả sản phẩm</span>

                            @if ($selectedCategory === 'all')
                                <i class="bi bi-check2"></i>
                            @endif

                        </label>

                        {{-- DANH MỤC --}}
                        @foreach ($categoryTree as $category)
                            @include('products.partials.category-item', [
                                'category' => $category,
                                'selectedCategory' => $selectedCategory,
                            ])
                        @endforeach

                    </div>

                    {{-- LỌC THEO KHOẢNG GIÁ --}}
                    <div class="filter-section">

                        <h3>KHOẢNG GIÁ</h3>

                        @foreach ($priceRanges as $value => $label)
                            <label class="filter-option {{ $selectedPrice === $value ? 'selected' : '' }}">

                                <input type="radio" name="price" value="{{ $value }}"
                                    {{ $selectedPrice === $value ? 'checked' : '' }} onchange="this.form.submit()">

                                <span>{{ $label }}</span>

                                @if ($selectedPrice === $value)
                                    <i class="bi bi-check2"></i>
                                @endif

                            </label>
                        @endforeach

                    </div>

                    {{-- LỌC TÌNH TRẠNG KHO --}}
                    <div class="filter-stock">

                        <label>
                            <input type="checkbox" name="in_stock" value="1" {{ $inStockOnly ? 'checked' : '' }}
                                onchange="this.form.submit()">

                            <span>Chỉ hiện sản phẩm còn hàng</span>
                        </label>

                    </div>

                </form>

            </aside>

            {{-- KHU VỰC DANH SÁCH SẢN PHẨM --}}
            <section class="catalog-results">

                {{-- THANH SẮP XẾP --}}
                <div class="catalog-sortbar">

                    <span class="sort-caption">
                        <i class="bi bi-sliders2"></i>
                        Sắp xếp theo:
                    </span>

                    <div class="sort-options">

                        @php
                            $sortOptions = [
                                'newest' => 'Mới nhất',
                                'price_asc' => 'Giá tăng dần',
                                'price_desc' => 'Giá giảm dần',
                            ];
                        @endphp

                        @foreach ($sortOptions as $value => $label)
                            <a href="{{ request()->fullUrlWithQuery([
                                'sort' => $value,
                                'page' => null,
                            ]) }}"
                                class="sort-link {{ $sort === $value ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach

                    </div>

                </div>

                {{-- KIỂM TRA SẢN PHẨM --}}
                @if ($products->isNotEmpty())

                    <div class="catalog-product-grid">

                        @foreach ($products as $product)
                            @php
                                // Giá bán thực tế
                                $sellingPrice =
                                    $product->sale_price !== null && $product->sale_price > 0
                                        ? $product->sale_price
                                        : $product->base_price;

                                // Tính phần trăm giảm giá
                                $discount =
                                    $product->base_price > 0 &&
                                    $product->sale_price !== null &&
                                    $product->sale_price > 0 &&
                                    $product->sale_price < $product->base_price
                                        ? round(
                                            (($product->base_price - $product->sale_price) / $product->base_price) *
                                                100,
                                        )
                                        : 0;
                            @endphp

                            <article class="catalog-product-card">

                                {{-- ẢNH SẢN PHẨM --}}
                                <a href="{{ route('products.show', $product->product_id) }}" class="catalog-product-image">

                                    <img src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('images/no-image.png') }}"
                                        alt="{{ $product->name }}" loading="{{ $loop->index < 6 ? 'eager' : 'lazy' }}">

                                    {{-- NHÃN GIẢM GIÁ --}}
                                    @if ($discount > 0)
                                        <span class="catalog-discount">
                                            -{{ $discount }}%
                                        </span>
                                    @endif

                                </a>

                                {{-- THÔNG TIN SẢN PHẨM --}}
                                <div class="catalog-product-info">

                                    {{-- DANH MỤC --}}
                                    <div class="catalog-product-meta">

                                        <span>
                                            {{ $product->category_name ?? 'Sản phẩm' }}
                                        </span>

                                    </div>

                                    {{-- TÊN SẢN PHẨM --}}
                                    <a href="{{ route('products.show', $product->product_id) }}"
                                        class="catalog-product-name">
                                        {{ $product->name }}
                                    </a>

                                    {{-- MÔ TẢ --}}
                                    <p class="catalog-product-description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 90) }}
                                    </p>

                                    {{-- GIÁ SẢN PHẨM --}}
                                    <div class="catalog-price-line">

                                        <strong>
                                            {{ number_format($sellingPrice, 0, ',', '.') }}₫
                                        </strong>

                                        @if ($discount > 0)
                                            <del>
                                                {{ number_format($product->base_price, 0, ',', '.') }}₫
                                            </del>
                                        @endif

                                    </div>

                                    {{-- TÌNH TRẠNG KHO VÀ NÚT THAO TÁC --}}
                                    <div class="catalog-product-actions">

                                        <span class="catalog-stock">

                                            @if ($product->stock > 0)
                                                <i class="bi bi-box-seam"></i>
                                                Còn {{ $product->stock }} sản phẩm
                                            @else
                                                <span class="text-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                    Hết hàng
                                                </span>
                                            @endif

                                        </span>

                                        <div class="catalog-action-buttons">

                                            {{-- CHI TIẾT --}}
                                            <a href="{{ route('products.show', $product->product_id) }}"
                                                class="catalog-detail-btn">
                                                Chi tiết
                                            </a>

                                            {{-- THÊM GIỎ HÀNG --}}
                                            @if ($product->stock > 0)
                                                @auth
                                                    <form method="POST"
                                                        action="{{ route('cart.add', $product->product_id) }}">
                                                        @csrf

                                                        <input type="hidden" name="quantity" value="1">

                                                        <button type="submit" class="catalog-cart-btn"
                                                            aria-label="Thêm vào giỏ hàng">
                                                            <i class="bi bi-cart3"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="catalog-cart-btn"
                                                        aria-label="Đăng nhập để thêm vào giỏ hàng"
                                                        onclick="requireLoginToCart()">
                                                        <i class="bi bi-cart3"></i>
                                                    </button>
                                                @endauth
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </article>
                        @endforeach

                    </div>

                    {{-- PHÂN TRANG --}}
                    <div class="catalog-pagination">
                        {{ $products->links() }}
                    </div>
                @else
                    {{-- KHÔNG TÌM THẤY SẢN PHẨM --}}
                    <div class="catalog-empty">

                        <i class="bi bi-search"></i>

                        <h2>Không tìm thấy sản phẩm</h2>

                        <p>
                            Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm của bạn.
                        </p>

                        <a href="{{ url('/products') }}" class="catalog-empty-button">
                            Xem tất cả sản phẩm
                        </a>

                    </div>

                @endif

            </section>

        </div>

    </div>

    <script>
        document.addEventListener('click', function(event) {

            const toggle = event.target.closest('.category-toggle');

            if (!toggle) return;

            const node = toggle.closest('.category-node');

            if (!node) return;

            node.classList.toggle('is-open');

            const isOpen = node.classList.contains('is-open');

            toggle.setAttribute('aria-expanded', isOpen);

            toggle.setAttribute(
                'aria-label',
                isOpen ? 'Thu gọn danh mục con' : 'Mở danh mục con'
            );

        });
    </script>
    @guest
        <script>
            function requireLoginToCart() {
                const confirmLogin = confirm(
                    'Bạn cần đăng nhập tài khoản để thêm sản phẩm vào giỏ hàng. Bạn có muốn đăng nhập ngay không?'
                );

                if (confirmLogin) {
                    window.location.href = "{{ route('login') }}";
                }
            }
        </script>
    @endguest
@endsection
