
@extends('layouts.app')

@section('title', 'ElectroTech | Siêu thị công nghệ chính hãng')

@section('content')
<div class="tech-home">

    {{-- HERO --}}
    <section class="tech-hero">
        <div class="hero-copy">
            <span class="hero-tag">
                <i class="bi bi-lightning-charge-fill"></i>
                Sản phẩm tiên phong công nghệ 2026
            </span>

            <h1>
                iPhone 16 Pro Max
                <span>Titan Siêu Nhẹ. Chip A18 Pro.</span>
            </h1>

            <p>
                Nút Camera Control hoàn toàn mới, màn hình Super Retina XDR
                6.9 inch viền siêu mỏng, thời lượng pin bền bỉ đến 33 giờ.
                Hàng chính hãng VN/A sẵn sàng giao ngay.
            </p>

            <div class="hero-price">
                <strong>33.490.000₫</strong>
                <del>35.990.000₫</del>
                <span>Tiết kiệm 2.500.000₫</span>
            </div>

            <div class="hero-actions">
                <a href="/products/1" class="tech-btn">
                    Xem chi tiết &amp; Mua ngay
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="/products" class="tech-btn tech-btn-dark">
                    Khám phá toàn bộ thiết bị
                </a>
            </div>

            <div class="hero-promises">
                <span><i class="bi bi-check-circle"></i> Bảo hành 12 tháng</span>
                <span><i class="bi bi-check-circle"></i> Trả góp 0% lãi suất</span>
                <span><i class="bi bi-check-circle"></i> Đổi mới 30 ngày</span>
            </div>
        </div>

        <div class="hero-visual">
            <img
                src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=900&q=85"
                alt="iPhone 16 Pro Max"
            >
            <div class="hero-product-label">
                <div>
                    <strong>Titan Sa Mạc (Desert Titanium)</strong>
                    <small>Cao cấp hơn. Nhẹ hơn. Thời thượng.</small>
                </div>
                <span>Còn 24 máy</span>
            </div>
        </div>
    </section>

    {{-- CATEGORIES --}}
    <section class="tech-section">
        <div class="section-heading">
            <div>
                <h2>Danh Mục Thiết Bị Nổi Bật</h2>
                <p>Khám phá các dòng sản phẩm công nghệ cao cấp chính hãng</p>
            </div>
            <a href="/products">Tất cả danh mục <i class="bi bi-chevron-right"></i></a>
        </div>

        <div class="category-grid">
            <a href="/products?category=phone" class="category-item">
                <span class="category-icon"><i class="bi bi-phone"></i></span>
                <strong>Điện Thoại</strong>
                <small>iPhone, Samsung, Xiaomi</small>
                <b>24+ mẫu</b>
            </a>

            <a href="/products?category=laptop" class="category-item">
                <span class="category-icon"><i class="bi bi-laptop"></i></span>
                <strong>Laptop &amp; Mac</strong>
                <small>MacBook, ROG, Gaming</small>
                <b>18+ mẫu</b>
            </a>

            <a href="/products?category=tablet" class="category-item">
                <span class="category-icon"><i class="bi bi-tablet"></i></span>
                <strong>Máy Tính Bảng</strong>
                <small>iPad Pro, OLED, Air</small>
                <b>12+ mẫu</b>
            </a>

            <a href="/products?category=audio" class="category-item">
                <span class="category-icon"><i class="bi bi-headphones"></i></span>
                <strong>Âm Thanh</strong>
                <small>Sony, JBL, Marshall</small>
                <b>30+ mẫu</b>
            </a>

            <a href="/products?category=watch" class="category-item">
                <span class="category-icon"><i class="bi bi-smartwatch"></i></span>
                <strong>Smartwatch</strong>
                <small>Apple Watch, Ultra</small>
                <b>15+ mẫu</b>
            </a>

            <a href="/products?category=accessory" class="category-item">
                <span class="category-icon"><i class="bi bi-keyboard"></i></span>
                <strong>Phụ Kiện</strong>
                <small>Keyboards, Logitech</small>
                <b>50+ mẫu</b>
            </a>
        </div>
    </section>

    {{-- FLASH SALE --}}
    <section class="flashsale-section">
        <div class="flashsale-heading">
            <div class="flashsale-title">
                <span class="flashsale-icon"><i class="bi bi-fire"></i></span>
                <div>
                    <h2>FLASH SALE GIÁ SỐC</h2>
                    <p>Cơ hội săn deal công nghệ giảm tới 30%!</p>
                </div>
                <span class="flashsale-today">CHỈ HÔM NAY</span>
            </div>

            <div class="flashsale-count">
                <i class="bi bi-clock"></i>
                Kết thúc trong:
                <b>09</b> : <b>41</b> : <b>03</b>
            </div>
        </div>

        <div class="sale-grid">
            <article class="sale-card">
                <div class="sale-image">
                    <span class="discount-badge">-7%</span>
                    <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=600&q=85" alt="iPhone 16 Pro Max">
                </div>
                <div class="sale-content">
                    <small>APPLE</small>
                    <h3>iPhone 16 Pro Max 256GB Chính Hãng VN/A</h3>
                    <div class="sale-price">33.490.000₫ <del>35.990.000₫</del></div>
                    <div class="sale-stock"><span style="width:72%"></span></div>
                    <div class="stock-label"><span>Đã bán 72%</span><b>Chỉ còn 24 cái</b></div>
                    <div class="sale-actions">
                        <a href="/products/1">Chi tiết</a>
                        <a href="/cart" aria-label="Thêm vào giỏ hàng"><i class="bi bi-cart3"></i></a>
                    </div>
                </div>
            </article>

            <article class="sale-card">
                <div class="sale-image">
                    <span class="discount-badge">-18%</span>
                    <img src="https://images.unsplash.com/photo-1707230492554-7b2e0c2cfdc8?auto=format&fit=crop&w=600&q=85" alt="Samsung Galaxy S24 Ultra">
                </div>
                <div class="sale-content">
                    <small>SAMSUNG</small>
                    <h3>Samsung Galaxy S24 Ultra 5G 12GB/256GB - AI Phone</h3>
                    <div class="sale-price">27.990.000₫ <del>33.990.000₫</del></div>
                    <div class="sale-stock"><span style="width:72%"></span></div>
                    <div class="stock-label"><span>Đã bán 72%</span><b>Chỉ còn 18 cái</b></div>
                    <div class="sale-actions">
                        <a href="/products">Chi tiết</a>
                        <a href="/cart" aria-label="Thêm vào giỏ hàng"><i class="bi bi-cart3"></i></a>
                    </div>
                </div>
            </article>

            <article class="sale-card">
                <div class="sale-image">
                    <span class="discount-badge">-20%</span>
                    <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=600&q=85" alt="Sony WH-1000XM5">
                </div>
                <div class="sale-content">
                    <small>SONY</small>
                    <h3>Tai nghe Chống Ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio</h3>
                    <div class="sale-price">6.990.000₫ <del>8.990.000₫</del></div>
                    <div class="sale-stock"><span style="width:65%"></span></div>
                    <div class="stock-label"><span>Đã bán 65%</span><b>Chỉ còn 35 cái</b></div>
                    <div class="sale-actions">
                        <a href="/products">Chi tiết</a>
                        <a href="/cart" aria-label="Thêm vào giỏ hàng"><i class="bi bi-cart3"></i></a>
                    </div>
                </div>
            </article>

            <article class="sale-card">
                <div class="sale-image">
                    <span class="discount-badge">-15%</span>
                    <img src="https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=600&q=85" alt="Logitech MX Master">
                </div>
                <div class="sale-content">
                    <small>LOGITECH</small>
                    <h3>Chuột Không Dây Logitech MX Master 3S For Mac / Windows</h3>
                    <div class="sale-price">2.190.000₫ <del>2.590.000₫</del></div>
                    <div class="sale-stock"><span style="width:72%"></span></div>
                    <div class="stock-label"><span>Đã bán 72%</span><b>Chỉ còn 43 cái</b></div>
                    <div class="sale-actions">
                        <a href="/products">Chi tiết</a>
                        <a href="/cart" aria-label="Thêm vào giỏ hàng"><i class="bi bi-cart3"></i></a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    {{-- BEST SELLERS --}}
    <section class="tech-section">
        <div class="section-heading">
            <div>
                <h2>Sản Phẩm Bán Chạy Nhất <span class="top-label">Top Đánh Giá</span></h2>
                <p>Những công nghệ được khách hàng tin tưởng lựa chọn</p>
            </div>
            <a href="/products">Xem tất cả <i class="bi bi-chevron-right"></i></a>
        </div>

        <div class="best-grid">
            <article class="best-card">
                <div class="best-image">
                    <span class="best-badge">Bán chạy</span>
                    <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=600&q=85" alt="iPhone 16 Pro Max">
                </div>
                <div class="best-content">
                    <div class="best-meta"><span>APPLE</span><b>★ 4.9 (51)</b></div>
                    <h3>iPhone 16 Pro Max 256GB Chính Hãng VN/A</h3>
                    <p>Khung Titan cao cấp, chip Apple A18 Pro mạnh mẽ, Camera Control đỉnh cao.</p>
                    <div class="best-price">33.490.000₫ <del>35.990.000₫</del></div>
                    <div class="best-bottom"><span>● Còn 24 trong kho</span><a href="/products/1">🛒 Mua ngay</a></div>
                </div>
            </article>

            <article class="best-card">
                <div class="best-image">
                    <span class="best-badge">Bán chạy</span>
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=85" alt="MacBook Pro">
                </div>
                <div class="best-content">
                    <div class="best-meta"><span>APPLE</span><b>★ 5.0 (35)</b></div>
                    <h3>MacBook Pro 14 M3 Pro (18GB / 512GB SSD) Space Black</h3>
                    <p>Chip M3 Pro, màn hình Liquid Retina XDR, hiệu năng mạnh mẽ.</p>
                    <div class="best-price">46.990.000₫ <del>49.990.000₫</del></div>
                    <div class="best-bottom"><span>● Còn 12 trong kho</span><a href="/products">🛒 Mua ngay</a></div>
                </div>
            </article>

            <article class="best-card">
                <div class="best-image">
                    <span class="best-badge">Bán chạy</span>
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=85" alt="Laptop Gaming">
                </div>
                <div class="best-content">
                    <div class="best-meta"><span>ASUS</span><b>★ 4.9 (42)</b></div>
                    <h3>Laptop Gaming ASUS ROG Zephyrus G16 (Core Ultra 9 / RTX 4070)</h3>
                    <p>Laptop gaming mạnh mẽ, màn hình OLED và hiệu năng vượt trội.</p>
                    <div class="best-price">54.990.000₫ <del>59.990.000₫</del></div>
                    <div class="best-bottom"><span>● Còn 7 trong kho</span><a href="/products">🛒 Mua ngay</a></div>
                </div>
            </article>

            <article class="best-card">
                <div class="best-image">
                    <span class="best-badge">Bán chạy</span>
                    <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=85" alt="iPad Pro">
                </div>
                <div class="best-content">
                    <div class="best-meta"><span>APPLE</span><b>★ 4.9 (47)</b></div>
                    <h3>iPad Pro 11 Inch M4 Wi-Fi 256GB - Siêu Mỏng Nhẹ</h3>
                    <p>Màn hình OLED sắc nét, thiết kế mỏng nhẹ và hiệu năng mạnh mẽ.</p>
                    <div class="best-price">26.490.000₫ <del>29.990.000₫</del></div>
                    <div class="best-bottom"><span>● Còn 14 trong kho</span><a href="/products">🛒 Mua ngay</a></div>
                </div>
            </article>
        </div>
    </section>

    {{-- PROMOTIONAL BANNERS --}}
    <section class="promo-grid">
        <a href="/products?category=laptop" class="promo-card promo-laptop">
            <div>
                <small>CẤU HÌNH ĐỈNH CAO</small>
                <h2>MacBook M3 Pro &amp; ASUS ROG RTX 4070</h2>
                <p>Trải nghiệm hiệu năng đỉnh cao, thiết kế không dây giới hạn.</p>
                <span>Xem các dòng Laptop <i class="bi bi-arrow-right"></i></span>
            </div>
            <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=500&q=85" alt="Laptop cao cấp">
        </a>

        <a href="/products?category=audio" class="promo-card promo-audio">
            <div>
                <small>TRẢI NGHIỆM ÂM THANH CHUẨN</small>
                <h2>Sony WH-1000XM5 &amp; Marshall Stanmore III</h2>
                <p>Nhập mã TECH500 giảm ngay 500.000₫.</p>
                <span>Khám phá Loa &amp; Tai nghe <i class="bi bi-arrow-right"></i></span>
            </div>
            <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=500&q=85" alt="Tai nghe cao cấp">
        </a>
    </section>

    {{-- TRUST --}}
    <section class="trust-section">
        <div class="trust-heading">
            <h2>Cam Kết Chất Lượng Tại ElectroTech</h2>
            <p>Trải nghiệm mua sắm an tâm với chính sách bảo hành và hỗ trợ số 1</p>
        </div>

        <div class="trust-grid">
            <div class="trust-item">
                <span class="trust-icon blue"><i class="bi bi-shield-check"></i></span>
                <strong>Chính Hãng 100%</strong>
                <small>Đầy đủ VAT &amp; CO/CQ</small>
            </div>
            <div class="trust-item">
                <span class="trust-icon green"><i class="bi bi-truck"></i></span>
                <strong>Giao Tốc Hành 2H</strong>
                <small>Nội thành HN &amp; TP.HCM</small>
            </div>
            <div class="trust-item">
                <span class="trust-icon orange"><i class="bi bi-arrow-repeat"></i></span>
                <strong>Đổi Mới 30 Ngày</strong>
                <small>Lỗi phần cứng đổi ngay</small>
            </div>
            <div class="trust-item">
                <span class="trust-icon purple"><i class="bi bi-lightning-charge"></i></span>
                <strong>Tích Điểm Tech VIP</strong>
                <small>Quy đổi voucher tri ân</small>
            </div>
        </div>
    </section>
</div>
@endsection
