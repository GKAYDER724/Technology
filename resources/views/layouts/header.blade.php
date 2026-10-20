<header class="et-header">
    {{-- Thanh thông tin trên cùng --}}
    <div class="et-topbar">
        <div class="et-container et-topbar-inner">
            <div class="et-topbar-left">
                <span><i class="bi bi-shield-check"></i> 100% Thiết Bị Chính Hãng VN/A</span>
                <span class="et-top-divider">|</span>
                <span><i class="bi bi-truck"></i> Giao Hỏa Tốc 2 giờ nội thành</span>
            </div>

            <div class="et-topbar-right">
                <span><i class="bi bi-telephone"></i> Hotline: 1800.6868 (Miễn phí)</span>
            </div>
        </div>
    </div>

    {{-- Header chính --}}
    <div class="et-main-header">
        <div class="et-container et-main-header-inner">

            <a href="{{ url('/') }}" class="et-logo">
                <span class="et-logo-icon">
                    <i class="bi bi-cpu"></i>
                </span>
                <span class="et-logo-text">
                    <strong>Electro<span>Tech</span></strong>
                    <small>ELECTRONICS STORE</small>
                </span>
            </a>

            <form action="{{ url('/products') }}" method="GET" class="et-search">
                <i class="bi bi-search"></i>
                <input type="search" name="search" placeholder="Tìm iPhone 16 Pro Max, MacBook M3, Sony XM5, Bàn phím"
                    aria-label="Tìm kiếm sản phẩm">
                <button type="submit">Tìm kiếm</button>
            </form>

            <a href="/notifications" class="et-header-icon" aria-label="Thông báo">
                <i class="bi bi-bell"></i>
                <span class="et-notification-dot">2</span>
            </a>

            <a href="{{ url('/cart') }}" class="et-cart">
                <i class="bi bi-cart3"></i>
                <span>Giỏ hàng</span>
                <b>1</b>
            </a>


            <div class="et-account-wrapper">

    @auth
        {{-- ĐÃ ĐĂNG NHẬP --}}
        @php
            $user = Auth::user();
        @endphp

        <button type="button" class="et-account" id="etAccountToggle"
            aria-expanded="false" aria-controls="etAccountDropdown">

            <span class="et-avatar">
                <i class="bi bi-person-fill"></i>
            </span>

            <span class="et-account-text">
                <strong>{{ $user->fullname }}</strong>
                <small>Tech VIP</small>
            </span>

            <i class="bi bi-chevron-down et-account-chevron"></i>
        </button>

        <div class="et-account-dropdown" id="etAccountDropdown">

            <div class="et-dropdown-profile">
                <strong>{{ $user->fullname }}</strong>
                <span>{{ $user->email }}</span>

                <div class="et-vip-info">
                    <span>Tech VIP</span>
                    <strong>1.250 điểm</strong>
                </div>
            </div>
<div class="et-dropdown-links">
                <a href="{{ url('/account/profile') }}">
                    <i class="bi bi-person"></i>
                    <span>Thông tin tài khoản</span>
                </a>

                <a href="{{ url('/orders') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Quản lý đơn hàng</span>
                </a>

                <a href="{{ url('/notifications') }}">
                    <i class="bi bi-bell"></i>
                    <span>Thông báo</span>
                </a>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Đăng xuất</button>
            </form>

        </div>

    @else
        {{-- CHƯA ĐĂNG NHẬP --}}
        <div class="et-account">
            <span class="et-avatar">
                <i class="bi bi-person-fill"></i>
            </span>

            <span class="et-account-text">
                <a href="{{ url('/login') }}">
                    <strong>Đăng nhập</strong>
                </a>
                <small>
                    <a href="{{ url('/register') }}">Đăng ký tài khoản</a>
                </small>
            </span>
        </div>

    @endauth

</div>


        </div>
    </div>

    {{-- Thanh danh mục --}}
    <nav class="et-category-nav">
        <div class="et-container et-category-inner">
            <a href="/products">Tất cả sản phẩm</a>
            <a href="/products?category=phone">Điện thoại di động</a>
            <a href="/products?category=laptop">Laptop &amp; Máy tính</a>
            <a href="/products?category=tablet">Máy tính bảng iPad</a>
            <a href="/products?category=audio">Tai nghe &amp; Loa</a>
            <a href="/products?category=smart-home">Đồng hồ thông minh</a>
            <a href="/products?category=accessory">Phụ kiện công nghệ</a>

            <div class="et-nav-spacer"></div>

            <a href="/products" class="et-nav-active">Tất cả sản phẩm</a>
            <a href="/orders">Đơn hàng của tôi</a>
        </div>
    </nav>
</header>
