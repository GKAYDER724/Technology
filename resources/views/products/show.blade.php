@extends('layouts.app')

@section('title', 'iPhone 16 Pro Max 256GB | ElectroTech')

@section('content')
    @php
        $product = [
            'brand' => 'APPLE',
            'sku' => 'PROD-IP16PM',
            'name' => 'iPhone 16 Pro Max 256GB Chính Hãng VN/A',
            'price' => 33490000,
            'old_price' => 35990000,
            'discount' => 7,
            'rating' => '4.9',
            'reviews' => 142,
            'sold' => 'Đã bán 350+ chiếc',
        ];

        $variants = [
            [
                'name' => 'Titan Sa Mạc',
                'color' => '#c8b49a',
                'price' => 33490000,
                'stock' => 'Còn 15 máy',
            ],
            [
                'name' => 'Titan Đen',
                'color' => '#25272b',
                'price' => 33490000,
                'stock' => 'Còn 6 máy',
            ],
            [
                'name' => 'Titan Trắng',
                'color' => '#e8e8ed',
                'price' => 38990000,
                'stock' => 'Còn 3 máy',
            ],
        ];

        $gallery = [
            'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=1000&q=90',
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1000&q=90',
            'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=1000&q=90',
        ];

        $specifications = [
            ['Màn hình', 'OLED 6.9" Super Retina XDR Promotion 120Hz'],
            ['Hệ điều hành', 'iOS 18 (Apple Intelligence)'],
            ['Vi xử lý', 'Apple A18 Pro (3nm thế hệ 2)'],
            ['Bộ nhớ trong', '256GB NVMe siêu tốc'],
            ['Camera sau', 'Chính 48MP + Góc rộng 48MP + Tele 5x 12MP'],
            ['Camera trước', '12MP TrueDepth 4K HDR'],
            ['Pin & Sạc', 'Xem video 33 giờ, sạc nhanh 30W, MagSafe 25W'],
            ['Trọng lượng', '227g'],
            ['Chính sách bảo hành', 'Bảo hành chính hãng 12 tháng tại các Trung tâm ủy quyền Apple Care VN.'],
        ];

        $relatedProducts = [
            [
                'brand' => 'SAMSUNG',
                'name' => 'Samsung Galaxy S24 Ultra 5G 12GB/256GB - AI Phone',
                'price' => 27990000,
                'image' =>
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=500&q=85',
            ],
        ];

        $formatPrice = fn($price) => number_format($price, 0, ',', '.') . '₫';
    @endphp

    <div class="product-detail-page" data-product-name="{{ $product['name'] }}">

        {{-- BREADCRUMB --}}
        <nav class="pd-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ url('/products') }}">PHONE</a>
            <i class="bi bi-chevron-right"></i>
            <span>{{ $product['name'] }}</span>
        </nav>

        {{-- PRODUCT OVERVIEW --}}
        <section class="pd-main-card">

            {{-- LEFT: PRODUCT GALLERY --}}
            <div class="pd-gallery">

                <div class="pd-main-image">
                    <span class="pd-discount">
                        Giảm {{ $product['discount'] }}%
                    </span>

                    <img id="pdMainImage" src="{{ $gallery[0] }}" alt="{{ $product['name'] }}">
                </div>

                <div class="pd-thumbnails">
                    @foreach ($gallery as $index => $image)
                        <button type="button" class="pd-thumbnail {{ $index === 0 ? 'active' : '' }}"
                            data-image="{{ $image }}" aria-label="Xem ảnh sản phẩm {{ $index + 1 }}">
                            <img src="{{ $image }}" alt="Ảnh {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>

                <div class="pd-gallery-bottom">
                    <button type="button" id="pdShare">
                        <i class="bi bi-share"></i>
                        Chia sẻ sản phẩm
                    </button>

                    <button type="button" id="pdFavorite">
                        <i class="bi bi-heart"></i>
                        Yêu thích
                    </button>
                </div>

            </div>

            {{-- RIGHT: PRODUCT INFORMATION --}}
            <div class="pd-information">

                <div class="pd-product-meta">
                    <span class="pd-brand">{{ $product['brand'] }}</span>
                    <span class="pd-meta-divider">|</span>
                    <span>Mã SP: {{ $product['sku'] }}</span>
                </div>

                <h1 class="pd-product-title">{{ $product['name'] }}</h1>

                <div class="pd-rating-row">
                    <span class="pd-rating">
                        <i class="bi bi-star-fill"></i>
                        {{ $product['rating'] }}
                    </span>

                    <a href="#pd-reviews" class="pd-review-count">
                        {{ $product['reviews'] }} đánh giá từ khách hàng
                    </a>

                    <span class="pd-sold">{{ $product['sold'] }}</span>
                </div>

                {{-- PRICE --}}
                <div class="pd-price-box">
                    <strong id="pdPrice">
                        {{ $formatPrice($product['price']) }}
                    </strong>

                    <del id="pdOldPrice">
                        {{ $formatPrice($product['old_price']) }}
                    </del>

                    <span class="pd-saving">
                        Tiết kiệm {{ $formatPrice($product['old_price'] - $product['price']) }}
                    </span>
                </div>

                {{-- COLOR / VARIANT --}}
                <div class="pd-variant-heading">
                    <span>Chọn phiên bản / Màu sắc:</span>
                    <strong id="pdSelectedVariant">
                        256GB - Titan Sa Mạc
                    </strong>
                </div>

                <div class="pd-variants">
                    @foreach ($variants as $index => $variant)
                        <button type="button" class="pd-variant {{ $index === 0 ? 'active' : '' }}"
                            data-name="{{ $variant['name'] }}" data-price="{{ $variant['price'] }}"
                            data-stock="{{ $variant['stock'] }}" data-color="{{ $variant['color'] }}">
                            <span class="pd-variant-name">
                                <span class="pd-color-dot" style="--variant-color: {{ $variant['color'] }}"></span>
                                {{ $variant['name'] }}
                            </span>

                            <strong>{{ $formatPrice($variant['price']) }}</strong>
                            <small>{{ $variant['stock'] }}</small>
                        </button>
                    @endforeach
                </div>

                {{-- STOCK --}}
                <div class="pd-stock-row">
                    <span>Tình trạng tồn kho:</span>

                    <span class="pd-stock-badge" id="pdStock">
                        <i class="bi bi-box-seam"></i>
                        Còn hàng (15 sản phẩm sẵn sàng giao ngay)
                    </span>
                </div>

                {{-- PROMOTION --}}
                <div class="pd-promotion">
                    <div class="pd-promotion-title">
                        <i class="bi bi-stars"></i>
                        Khuyến mãi đặc quyền khi mua hôm nay:
                    </div>

                    <ul>
                        <li>
                            Nhập mã <strong>TECH500</strong> giảm thêm
                            500.000đ cho đơn hàng từ 5.000.000đ
                        </li>
                        <li>
                            Tặng gói bảo hành rơi vỡ VIP 6 tháng độc quyền tại ElectroTech
                        </li>
                        <li>
                            Hỗ trợ chuyển đổi dữ liệu miễn phí tại quầy và giao nhanh 2h
                        </li>
                    </ul>
                </div>

                {{-- QUANTITY --}}
                <div class="pd-quantity-row">
                    <span>Số lượng:</span>

                    <div class="pd-quantity-control">
                        <button type="button" id="pdDecrease" aria-label="Giảm số lượng">-</button>
                        <input type="number" id="pdQuantity" value="1" min="1" max="15" readonly>
                        <button type="button" id="pdIncrease" aria-label="Tăng số lượng">+</button>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="pd-action-buttons">
                    <button type="button" class="pd-add-cart" id="pdAddCart">
                        <i class="bi bi-cart3"></i>
                        Thêm Vào Giỏ Hàng
                    </button>

                    <button type="button" class="pd-buy-now" id="pdBuyNow">
                        <i class="bi bi-lightning-charge"></i>
                        Mua Ngay Giao Tận Nơi
                    </button>
                </div>

                {{-- POLICIES --}}
                <div class="pd-policies">
                    <div>
                        <i class="bi bi-shield-check"></i>
                        <span>Bảo hành chính hãng 12 tháng</span>
                    </div>

                    <div>
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Lỗi 1 đổi 1 trong 30 ngày</span>
                    </div>

                    <div>
                        <i class="bi bi-truck"></i>
                        <span>Giao hàng miễn phí toàn quốc</span>
                    </div>
                </div>

            </div>
        </section>

        {{-- SPECIFICATIONS / DESCRIPTION / REVIEWS --}}
        <section class="pd-details-card" id="pd-details">

            <div class="pd-detail-tabs" role="tablist">
                <button type="button" class="pd-detail-tab active" data-tab="specifications">
                    Thông Số Kỹ Thuật
                </button>

                <button type="button" class="pd-detail-tab" data-tab="description">
                    Mô Tả Chi Tiết
                </button>

                <button type="button" class="pd-detail-tab" data-tab="reviews" id="pd-reviews">
                    Đánh Giá &amp; Nhận Xét
                    <span class="pd-review-number">2</span>
                </button>
            </div>

            {{-- TAB 1 --}}
            <div class="pd-tab-content active" id="pdTabSpecifications">

                <h2 class="pd-spec-title">
                    <i class="bi bi-cpu"></i>
                    Bảng thông số kỹ thuật tiêu chuẩn
                </h2>

                <div class="pd-spec-table">
                    @foreach ($specifications as $spec)
                        <div class="pd-spec-row">
                            <div>{{ $spec[0] }}</div>
                            <div>{{ $spec[1] }}</div>
                        </div>
                    @endforeach
                </div>

            </div>

            {{-- TAB 2 --}}
            <div class="pd-tab-content" id="pdTabDescription">

                <h2 class="pd-spec-title">
                    <i class="bi bi-file-text"></i>
                    Mô tả chi tiết sản phẩm
                </h2>

                <div class="pd-description">
                    <h3>iPhone 16 Pro Max 256GB Chính Hãng VN/A</h3>

                    <p>
                        Sở hữu thiết kế cao cấp, màn hình Super Retina XDR
                        cùng hiệu năng mạnh mẽ, iPhone 16 Pro Max đáp ứng
                        nhu cầu làm việc, giải trí và sáng tạo nội dung.
                    </p>

                    <p>
                        Sản phẩm có hệ thống camera tiên tiến, dung lượng
                        lưu trữ 256GB và chính sách bảo hành chính hãng.
                    </p>
                </div>

            </div>

            {{-- TAB 3 --}}
            <div class="pd-tab-content" id="pdTabReviews">

                <h2 class="pd-spec-title">
                    <i class="bi bi-star"></i>
                    Đánh giá từ khách hàng
                </h2>


                <div class="pd-review-summary">
                    <strong>4.9/5</strong>

                    <div class="pd-review-summary-info">
                        <div class="pd-review-stars">★★★★★</div>
                        <p>Dựa trên {{ $product['reviews'] }} đánh giá từ khách hàng</p>
                    </div>

                    <button type="button" class="pd-open-review-modal" id="pdOpenReviewModal">
                        <i class="bi bi-chat-square-text"></i>
                        Viết đánh giá sản phẩm
                    </button>
                </div>


                <div class="pd-review-item">
                    <div class="pd-review-avatar">A</div>
                    <div>
                        <strong>Nguyễn Minh Anh</strong>
                        <div class="pd-review-stars">★★★★★</div>
                        <p>Sản phẩm đẹp, đóng gói cẩn thận, giao hàng nhanh.</p>
                    </div>
                </div>

                <div class="pd-review-item">
                    <div class="pd-review-avatar">H</div>
                    <div>
                        <strong>Trần Hoàng</strong>
                        <div class="pd-review-stars">★★★★★</div>
                        <p>Máy hoạt động tốt, ngoại hình đẹp, đúng mô tả.</p>
                    </div>
                </div>

            </div>

        </section>

        {{-- RELATED PRODUCTS --}}
        <section class="pd-related-section">

            <h2>Sản phẩm cùng phân khúc liên quan</h2>

            <div class="pd-related-grid">
                @foreach ($relatedProducts as $related)
                    <a href="{{ url('/products') }}" class="pd-related-card">

                        <div class="pd-related-image">
                            <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}">
                        </div>

                        <div class="pd-related-info">
                            <span>{{ $related['brand'] }}</span>
                            <h3>{{ $related['name'] }}</h3>

                            <strong>{{ $formatPrice($related['price']) }}</strong>
                        </div>

                    </a>
                @endforeach
            </div>

        </section>

    </div>


    {{-- REVIEW MODAL --}}
    <div class="pd-review-modal" id="pdReviewModal" aria-hidden="true">
        <div class="pd-review-overlay" data-close-review></div> 

        <div class="pd-review-dialog" role="dialog" aria-modal="true" aria-labelledby="pdReviewModalTitle">

            <div class="pd-review-modal-header">
                <div>
                    <span class="pd-review-modal-eyebrow">
                        ELECTROTECH CUSTOMER REVIEW
                    </span>

                    <h2 id="pdReviewModalTitle">Viết đánh giá sản phẩm</h2>

                    <p>Chia sẻ trải nghiệm của bạn để giúp khách hàng khác.</p>
                </div>

                <button type="button" class="pd-review-close" id="pdCloseReviewModal"
                    aria-label="Đóng cửa sổ đánh giá">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="pdReviewForm">
                @csrf

                {{-- SẢN PHẨM --}}
                <div class="pd-review-product">
                    <img id="pdReviewProductImage" src="{{ $gallery[0] }}" alt="{{ $product['name'] }}">

                    <div class="pd-review-product-info">
                        <span class="pd-review-product-label">
                            SẢN PHẨM ĐANG ĐÁNH GIÁ
                        </span>

                        <h3>{{ $product['name'] }}</h3>

                        <p id="pdReviewVariant">256GB - Titan Sa Mạc</p>

                        <strong id="pdReviewProductPrice">
                            {{ $formatPrice($product['price']) }}
                        </strong>
                    </div>

                    <i class="bi bi-patch-check-fill pd-review-verified-icon"></i>
                </div>

                {{-- CHỌN SỐ SAO --}}
                <div class="pd-review-field">
                    <label class="pd-review-label">
                        Mức độ hài lòng <span>*</span>
                    </label>

                    <div class="pd-review-star-picker" id="pdReviewStarPicker" role="group"
                        aria-label="Chọn số sao đánh giá">

                        @for ($star = 1; $star <= 5; $star++)
                            <button type="button" class="pd-review-star {{ $star <= 5 ? 'active' : '' }}"
                                data-star="{{ $star }}" aria-label="{{ $star }} sao"
                                aria-pressed="{{ $star === 5 ? 'true' : 'false' }}">
                                <i class="bi bi-star-fill"></i>
                            </button>
                        @endfor
                    </div>

                    <div class="pd-review-rating-caption" id="pdReviewRatingCaption">
                        Tuyệt vời - Rất hài lòng
                    </div>

                    <input type="hidden" name="rating" id="pdReviewRating" value="5">

                    <p class="pd-review-error" id="pdReviewRatingError"></p>
                </div>

                {{-- TIÊU ĐỀ --}}
                <div class="pd-review-field">
                    <label for="pdReviewTitle" class="pd-review-label">
                        Tiêu đề đánh giá <span>*</span>
                    </label>

                    <input type="text" name="title" id="pdReviewTitle" maxlength="100"
                        placeholder="Ví dụ: Sản phẩm tốt, đáng mua..." required>

                    <div class="pd-review-input-footer">
                        <span class="pd-review-error" id="pdReviewTitleError"></span>
                        <span><span id="pdReviewTitleCount">0</span>/100</span>
                    </div>
                </div>

                {{-- NỘI DUNG --}}
                <div class="pd-review-field">
                    <label for="pdReviewContent" class="pd-review-label">
                        Nội dung nhận xét <span>*</span>
                    </label>

                    <textarea name="content" id="pdReviewContent" rows="4" minlength="10" maxlength="1500"
                        placeholder="Chất lượng sản phẩm, thiết kế, hiệu năng, trải nghiệm sử dụng..." required></textarea>

                    <div class="pd-review-input-footer">
                        <span class="pd-review-error" id="pdReviewContentError"></span>
                        <span><span id="pdReviewContentCount">0</span>/1500</span>
                    </div>
                </div>

                {{-- ẢNH MINH CHỨNG --}}
                <div class="pd-review-field">
                    <label class="pd-review-label">
                        Hình ảnh thực tế
                        <span class="pd-review-optional">(Tùy chọn)</span>
                    </label>

                    <label for="pdReviewImages" class="pd-review-upload">
                        <i class="bi bi-cloud-arrow-up"></i>

                        <strong>Nhấn để tải ảnh lên</strong>

                        <span>PNG, JPG, WEBP · Tối đa 5 ảnh, mỗi ảnh 5MB</span>
                    </label>

                    <input type="file" id="pdReviewImages" name="images[]" accept="image/png,image/jpeg,image/webp"
                        multiple hidden>

                    <div class="pd-review-image-preview" id="pdReviewImagePreview"></div>

                    <p class="pd-review-error" id="pdReviewImagesError"></p>
                </div>

                {{-- XÁC NHẬN --}}
                <label class="pd-review-confirm">
                    <input type="checkbox" name="confirmed_purchase" id="pdReviewConfirmed">

                    <span>
                        Tôi xác nhận đánh giá dựa trên trải nghiệm thực tế
                        với sản phẩm và đồng ý với
                        <a href="{{ url('/privacy-policy') }}" target="_blank">
                            chính sách đánh giá
                        </a>
                        của ElectroTech.
                    </span>
                </label>

                <p class="pd-review-error" id="pdReviewConfirmError"></p>

                <div class="pd-review-modal-footer">
                    <button type="button" class="pd-review-cancel" data-close-review>
                        Hủy bỏ
                    </button>

                    <button type="submit" class="pd-review-submit">
                        <i class="bi bi-send-fill"></i>
                        Gửi đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- INTERACTIONS --}}

    {{-- PRODUCT DETAIL JAVASCRIPT --}}
    <script src="{{ asset('js/product-detail.js') }}" defer></script>
@endsection

