@extends('layouts.app')

@section('title', ($product->name ?? 'Chi tiết sản phẩm') . ' | ElectroTech')

@section('content')

    @php
        // Chọn biến thể đầu tiên còn hoạt động nếu sản phẩm có biến thể.
        $activeVariants = $variants ?? collect();
        $selectedVariant = $activeVariants->first();
        // Giá sản phẩm mặc định.
        $basePrice = $product->base_price ?? 0;
        $salePrice = $product->sale_price ?? null;
        $sellingPrice = $salePrice !== null && $salePrice > 0 && $salePrice < $basePrice ? $salePrice : $basePrice;

        // Nếu có biến thể thì lấy giá của biến thể đầu tiên.
        if ($selectedVariant) {
            $variantPrice = $selectedVariant->price ?? $basePrice;
            $variantSalePrice = $selectedVariant->sale_price ?? null;

            $sellingPrice =
                $variantSalePrice !== null && $variantSalePrice > 0 && $variantSalePrice < $variantPrice
                    ? $variantSalePrice
                    : $variantPrice;

            $basePrice = $variantPrice;
            $salePrice = $variantSalePrice;
        }

        // Tính phần trăm giảm giá.
        $discount =
            $salePrice !== null && $salePrice > 0 && $salePrice < $basePrice
                ? round((($basePrice - $salePrice) / $basePrice) * 100)
                : 0;
        // Tồn kho mặc định.
        $stock = $selectedVariant ? (int) $selectedVariant->stock : (int) $product->stock;
        // SKU.
        $sku = $selectedVariant->sku ?? null;
        // Định dạng giá tiền.
        $formatPrice = fn($price) => number_format((float) $price, 0, ',', '.') . '₫';
        // Hỗ trợ cả ảnh Cloudinary và ảnh lưu trong storage.
        $imageUrl = function ($image) {
            if (!$image) {
                return asset('images/no-image.png');
            }

            if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                return $image;
            }

            return asset('storage/' . ltrim($image, '/'));
        };

        // Danh sách ảnh sản phẩm.
        $gallery = $productImages ?? collect();
        // Ảnh đại diện.
        $mainImage = $gallery->firstWhere('is_primary', 1) ?? $gallery->first();
        $mainImageUrl = $mainImage ? $imageUrl($mainImage->image) : asset('images/no-image.png');
        // Nếu biến thể có ảnh riêng thì ưu tiên ảnh biến thể.
        if ($selectedVariant && !empty($selectedVariant->image)) {
            $mainImageUrl = $imageUrl($selectedVariant->image);
        }
        // Tên biến thể đang chọn.
        $selectedVariantName = $selectedVariant ? $selectedVariant->variant_name : 'Mặc định';
    @endphp

    <div class="product-detail-page" data-product-name="{{ $product->name }}" data-product-id="{{ $product->product_id }}">
        {{-- BREADCRUMB --}}
        <nav class="pd-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ url('/products') }}">Sản phẩm</a>
            <i class="bi bi-chevron-right"></i>
            @if (!empty($product->category_name))
                <a href="{{ url('/products?category=' . $product->category_id) }}">
                    {{ $product->category_name }}
                </a>

                <i class="bi bi-chevron-right"></i>
            @endif
            <span>{{ $product->name }}</span>
        </nav>
        {{-- PRODUCT OVERVIEW --}}
        <section class="pd-main-card">
            {{-- LEFT: PRODUCT GALLERY --}}
            <div class="pd-gallery">
                <div class="pd-main-image">
                    @if ($discount > 0)
                        <span class="pd-discount">
                            Giảm {{ $discount }}%
                        </span>
                    @endif
                    <img id="pdMainImage" src="{{ $mainImageUrl }}" alt="{{ $product->name }}">
                </div>
                {{-- PRODUCT THUMBNAILS --}}
                <div class="pd-thumbnails">
                    @if ($gallery->isNotEmpty())
                        @foreach ($gallery as $index => $image)
                            <button type="button"
                                class="pd-thumbnail {{ $image->image === ($mainImage->image ?? null) ? 'active' : '' }}"
                                data-image="{{ $imageUrl($image->image) }}"
                                aria-label="Xem ảnh sản phẩm {{ $index + 1 }}">

                                <img src="{{ $imageUrl($image->image) }}"
                                    alt="{{ $product->name }} - Ảnh {{ $index + 1 }}">
                            </button>
                        @endforeach
                    @else
                        <button type="button" class="pd-thumbnail active">
                            <img src="{{ asset('images/no-image.png') }}" alt="{{ $product->name }}">
                        </button>
                    @endif
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
                {{-- BRAND / SKU --}}
                <div class="pd-product-meta">
                    <span class="pd-brand">
                        {{ $product->category_name ?? 'ELECTROTECH' }}
                    </span>
                    <span class="pd-meta-divider">|</span>
                    <span>
                        Mã SP:
                        <span id="pdSku">
                            {{ $sku ?? 'Đang cập nhật' }}
                        </span>
                    </span>
                </div>
                {{-- PRODUCT NAME --}}
                <h1 class="pd-product-title">
                    {{ $product->name }}
                </h1>
                {{-- RATING --}}
                <div class="pd-rating-row">
                    <span class="pd-rating">
                        <i class="bi bi-star"></i>
                        Chưa có đánh giá
                    </span>
                    <a href="#pd-reviews" class="pd-review-count">
                        Xem đánh giá sản phẩm
                    </a>
                </div>
                {{-- PRICE --}}
                <div class="pd-price-box">
                    <strong id="pdPrice">
                        {{ $formatPrice($sellingPrice) }}
                    </strong>
                    @if ($discount > 0)
                        <del id="pdOldPrice">
                            {{ $formatPrice($basePrice) }}
                        </del>

                        <span class="pd-saving">
                            Tiết kiệm
                            {{ $formatPrice($basePrice - $sellingPrice) }}
                        </span>
                    @else
                        <del id="pdOldPrice" style="display:none;"></del>
                        <span class="pd-saving" style="display:none;"></span>
                    @endif

                </div>
                {{-- VARIANTS --}}
                <div class="pd-variant-heading">

                    <span>Chọn phiên bản / Màu sắc:</span>

                    <strong id="pdSelectedVariant">
                        {{ $selectedVariantName }}
                    </strong>

                </div>
                <div class="pd-variants">

                    @forelse ($activeVariants as $index => $variant)
                        @php
                            $variantBasePrice = (float) ($variant->price ?? 0);
                            $variantSalePrice = $variant->sale_price ?? null;

                            $variantSellingPrice =
                                $variantSalePrice !== null &&
                                $variantSalePrice > 0 &&
                                $variantSalePrice < $variantBasePrice
                                    ? $variantSalePrice
                                    : $variantBasePrice;

                            $variantDiscount =
                                $variantSalePrice !== null &&
                                $variantSalePrice > 0 &&
                                $variantSalePrice < $variantBasePrice
                                    ? round((($variantBasePrice - $variantSalePrice) / $variantBasePrice) * 100)
                                    : 0;

                            $variantImage = !empty($variant->image) ? $imageUrl($variant->image) : $mainImageUrl;
                        @endphp

                        <button type="button"
                            class="pd-variant {{ $selectedVariant && $selectedVariant->variant_id == $variant->variant_id ? 'active' : '' }}"
                            data-variant-id="{{ $variant->variant_id }}" data-name="{{ $variant->variant_name }}"
                            data-price="{{ $variantSellingPrice }}"
                            data-old-price="{{ $variantDiscount > 0 ? $variantBasePrice : '' }}"
                            data-discount="{{ $variantDiscount }}" data-stock="{{ $variant->stock }}"
                            data-sku="{{ $variant->sku }}" data-image="{{ $variantImage }}">

                            <span class="pd-variant-name">

                                <span class="pd-color-dot" style="--variant-color: #d1d5db">
                                </span>

                                {{ $variant->variant_name }}

                            </span>

                            <strong>
                                {{ $formatPrice($variantSellingPrice) }}
                            </strong>

                            <small>
                                @if ($variant->stock > 0)
                                    Còn {{ $variant->stock }} sản phẩm
                                @else
                                    Hết hàng
                                @endif
                            </small>

                        </button>

                    @empty

                        <p>Sản phẩm hiện chưa có phiên bản.</p>
                    @endforelse

                </div>
                {{-- STOCK --}}
                <div class="pd-stock-row">

                    <span>Tình trạng tồn kho:</span>

                    <span class="pd-stock-badge" id="pdStock">

                        @if ($stock > 0)
                            <i class="bi bi-box-seam"></i>

                            Còn hàng ({{ $stock }} sản phẩm sẵn sàng giao ngay)
                        @else
                            <i class="bi bi-x-circle"></i>

                            Hết hàng
                        @endif

                    </span>
                </div>
                {{-- PROMOTION --}}
                <div class="pd-promotion">

                    <div class="pd-promotion-title">
                        <i class="bi bi-stars"></i>
                        Thông tin ưu đãi:
                    </div>

                    <ul>
                        <li>
                            Sản phẩm chính hãng, có nguồn gốc rõ ràng.
                        </li>

                        <li>
                            Hỗ trợ tư vấn và hướng dẫn sử dụng sản phẩm.
                        </li>

                        <li>
                            Chính sách bảo hành theo quy định của cửa hàng.
                        </li>
                    </ul>

                </div>


                {{-- QUANTITY --}}
                <div class="pd-quantity-row">

                    <span>Số lượng:</span>

                    <div class="pd-quantity-control">

                        <button type="button" id="pdDecrease" aria-label="Giảm số lượng">
                            -
                        </button>

                        <input type="number" id="pdQuantity" value="1" min="1" max="{{ max(1, $stock) }}"
                            readonly>

                        <button type="button" id="pdIncrease" aria-label="Tăng số lượng">
                            +
                        </button>

                    </div>

                </div>


                {{-- ACTIONS --}}
                {{-- FORM KẾT NỐI GIỎ HÀNG --}}
                <form id="pdCartForm" action="{{ route('cart.add', $product->product_id) }}" method="POST" hidden>

                    @csrf

                    <input type="hidden" name="variant_id" id="pdCartVariantId">

                    <input type="hidden" name="quantity" id="pdCartQuantity" value="1">

                    <input type="hidden" name="buy_now" id="pdCartBuyNow" value="0">

                </form>
                <div class="pd-action-buttons">

                    <button type="button" class="pd-add-cart" id="pdAddCart" {{ $stock <= 0 ? 'disabled' : '' }}>

                        <i class="bi bi-cart3"></i>

                        Thêm Vào Giỏ Hàng

                    </button>

                    <button type="button" class="pd-buy-now" id="pdBuyNow" {{ $stock <= 0 ? 'disabled' : '' }}>

                        <i class="bi bi-lightning-charge"></i>

                        Mua Ngay Giao Tận Nơi

                    </button>

                </div>


                {{-- POLICIES --}}
                <div class="pd-policies">

                    <div>
                        <i class="bi bi-shield-check"></i>
                        <span>Bảo hành theo chính sách sản phẩm</span>
                    </div>

                    <div>
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Hỗ trợ đổi trả theo quy định</span>
                    </div>

                    <div>
                        <i class="bi bi-truck"></i>
                        <span>Hỗ trợ giao hàng</span>
                    </div>

                </div>

            </div>

        </section>


        {{-- SPECIFICATIONS / DESCRIPTION / REVIEWS --}}
        <section class="pd-details-card" id="pd-details">

            <div class="pd-detail-tabs" role="tablist">

                <button type="button" class="pd-detail-tab active" data-tab="specifications">
                    Thông Tin Sản Phẩm
                </button>

                <button type="button" class="pd-detail-tab" data-tab="description">
                    Mô Tả Chi Tiết
                </button>

                <button type="button" class="pd-detail-tab" data-tab="reviews" id="pd-reviews">

                    Đánh Giá &amp; Nhận Xét

                    <span class="pd-review-number">0</span>

                </button>

            </div>


            {{-- TAB 1: PRODUCT INFORMATION --}}
            <div class="pd-tab-content active" id="pdTabSpecifications">

                <h2 class="pd-spec-title">

                    <i class="bi bi-cpu"></i>

                    Thông tin sản phẩm

                </h2>

                <div class="pd-spec-table">

                    <div class="pd-spec-row">
                        <div>Tên sản phẩm</div>
                        <div>{{ $product->name }}</div>
                    </div>

                    <div class="pd-spec-row">
                        <div>Danh mục</div>
                        <div>{{ $product->category_name ?? 'Chưa phân loại' }}</div>
                    </div>

                    <div class="pd-spec-row">
                        <div>Mã sản phẩm</div>
                        <div>{{ $product->product_id }}</div>
                    </div>

                    <div class="pd-spec-row">
                        <div>Giá niêm yết</div>
                        <div>{{ $formatPrice($product->base_price) }}</div>
                    </div>

                    <div class="pd-spec-row">
                        <div>Giá khuyến mãi</div>
                        <div>
                            @if ($product->sale_price && $product->sale_price > 0)
                                {{ $formatPrice($product->sale_price) }}
                            @else
                                Không có
                            @endif
                        </div>
                    </div>

                    <div class="pd-spec-row">
                        <div>Tồn kho sản phẩm</div>
                        <div>{{ $product->stock }}</div>
                    </div>

                    <div class="pd-spec-row">
                        <div>Trạng thái</div>
                        <div>
                            {{ $product->status === 'active' ? 'Đang kinh doanh' : 'Ngừng kinh doanh' }}
                        </div>
                    </div>

                    @if ($selectedVariant)
                        <div class="pd-spec-row">
                            <div>Phiên bản</div>
                            <div>{{ $selectedVariant->variant_name }}</div>
                        </div>

                        <div class="pd-spec-row">
                            <div>SKU</div>
                            <div>{{ $selectedVariant->sku }}</div>
                        </div>
                    @endif

                </div>

            </div>


            {{-- TAB 2: DESCRIPTION --}}
            <div class="pd-tab-content" id="pdTabDescription">

                <h2 class="pd-spec-title">

                    <i class="bi bi-file-text"></i>

                    Mô tả chi tiết sản phẩm

                </h2>

                <div class="pd-description">

                    @if (!empty($product->description))
                        {!! $product->description !!}
                    @else
                        <p>Sản phẩm chưa có mô tả chi tiết.</p>
                    @endif

                </div>

            </div>


            {{-- TAB 3: REVIEWS --}}
            <div class="pd-tab-content" id="pdTabReviews">

                <h2 class="pd-spec-title">

                    <i class="bi bi-star"></i>

                    Đánh giá từ khách hàng

                </h2>


                <div class="pd-review-summary">

                    <strong>0/5</strong>

                    <div class="pd-review-summary-info">

                        <div class="pd-review-stars">
                            ☆☆☆☆☆
                        </div>

                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>

                    </div>

                    @auth
                        {{-- ĐÃ ĐĂNG NHẬP: ĐƯỢC PHÉP ĐÁNH GIÁ --}}
                        <button type="button" class="pd-open-review-modal" id="pdOpenReviewModal">

                            <i class="bi bi-chat-square-text"></i>

                            Viết đánh giá sản phẩm

                        </button>
                    @else
                        {{-- CHƯA ĐĂNG NHẬP: YÊU CẦU ĐĂNG NHẬP --}}
                        <button type="button" class="pd-open-review-modal" onclick="requireLoginToReview()">

                            <i class="bi bi-chat-square-text"></i>

                            Viết đánh giá sản phẩm

                        </button>
                    @endauth

                </div>


                <div class="pd-review-item">

                    <div>
                        <strong>Chưa có đánh giá</strong>

                        <p>
                            Hãy là người đầu tiên chia sẻ trải nghiệm
                            của bạn về sản phẩm này.
                        </p>
                    </div>

                </div>

            </div>

        </section>


        {{-- RELATED PRODUCTS --}}
        <section class="pd-related-section">

            <h2>Sản phẩm liên quan</h2>

            <div class="pd-related-grid">

                @forelse ($relatedProducts as $related)
                    @php
                        $relatedBasePrice = $related->base_price ?? 0;

                        $relatedSalePrice = $related->sale_price ?? null;

                        $relatedSellingPrice =
                            $relatedSalePrice !== null && $relatedSalePrice > 0 && $relatedSalePrice < $relatedBasePrice
                                ? $relatedSalePrice
                                : $relatedBasePrice;
                    @endphp

                    <a href="{{ route('products.show', $related->product_id) }}" class="pd-related-card">

                        <div class="pd-related-image">

                            <img src="{{ !empty($related->product_image) ? $imageUrl($related->product_image) : asset('images/no-image.png') }}"
                                alt="{{ $related->name }}">

                        </div>

                        <div class="pd-related-info">

                            <span>ElectroTech</span>

                            <h3>{{ $related->name }}</h3>

                            <strong>
                                {{ $formatPrice($relatedSellingPrice) }}
                            </strong>

                        </div>

                    </a>

                @empty

                    <p>Chưa có sản phẩm liên quan.</p>
                @endforelse

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

                    <h2 id="pdReviewModalTitle">
                        Viết đánh giá sản phẩm
                    </h2>

                    <p>
                        Chia sẻ trải nghiệm của bạn để giúp khách hàng khác.
                    </p>

                </div>

                <button type="button" class="pd-review-close" id="pdCloseReviewModal"
                    aria-label="Đóng cửa sổ đánh giá">

                    <i class="bi bi-x-lg"></i>

                </button>

            </div>


            <form id="pdReviewForm">

                @csrf

                {{-- PRODUCT --}}
                <div class="pd-review-product">

                    <img id="pdReviewProductImage" src="{{ $mainImageUrl }}" alt="{{ $product->name }}">

                    <div class="pd-review-product-info">

                        <span class="pd-review-product-label">
                            SẢN PHẨM ĐANG ĐÁNH GIÁ
                        </span>

                        <h3>{{ $product->name }}</h3>

                        <p id="pdReviewVariant">
                            {{ $selectedVariantName }}
                        </p>

                        <strong id="pdReviewProductPrice">
                            {{ $formatPrice($sellingPrice) }}
                        </strong>

                    </div>

                    <i class="bi bi-patch-check-fill pd-review-verified-icon"></i>

                </div>


                {{-- STAR RATING --}}
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


                {{-- TITLE --}}
                <div class="pd-review-field">

                    <label for="pdReviewTitle" class="pd-review-label">

                        Tiêu đề đánh giá <span>*</span>

                    </label>

                    <input type="text" name="title" id="pdReviewTitle" maxlength="100"
                        placeholder="Ví dụ: Sản phẩm tốt, đáng mua..." required>

                    <div class="pd-review-input-footer">

                        <span class="pd-review-error" id="pdReviewTitleError"></span>

                        <span>
                            <span id="pdReviewTitleCount">0</span>/100
                        </span>

                    </div>

                </div>


                {{-- CONTENT --}}
                <div class="pd-review-field">

                    <label for="pdReviewContent" class="pd-review-label">

                        Nội dung nhận xét <span>*</span>

                    </label>

                    <textarea name="content" id="pdReviewContent" rows="4" minlength="10" maxlength="1500"
                        placeholder="Chia sẻ trải nghiệm sử dụng sản phẩm..." required></textarea>

                    <div class="pd-review-input-footer">

                        <span class="pd-review-error" id="pdReviewContentError"></span>

                        <span>
                            <span id="pdReviewContentCount">0</span>/1500
                        </span>

                    </div>

                </div>


                {{-- IMAGES --}}
                <div class="pd-review-field">

                    <label class="pd-review-label">

                        Hình ảnh thực tế

                        <span class="pd-review-optional">
                            (Tùy chọn)
                        </span>

                    </label>

                    <label for="pdReviewImages" class="pd-review-upload">

                        <i class="bi bi-cloud-arrow-up"></i>

                        <strong>Nhấn để tải ảnh lên</strong>

                        <span>
                            PNG, JPG, WEBP · Tối đa 5 ảnh, mỗi ảnh 5MB
                        </span>

                    </label>

                    <input type="file" id="pdReviewImages" name="images[]" accept="image/png,image/jpeg,image/webp"
                        multiple hidden>

                    <div class="pd-review-image-preview" id="pdReviewImagePreview"></div>

                    <p class="pd-review-error" id="pdReviewImagesError"></p>

                </div>


                {{-- CONFIRM --}}
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

    @guest
        <script>
            function requireLoginToReview() {
                const confirmLogin = confirm(
                    'Bạn cần đăng nhập tài khoản để viết đánh giá sản phẩm. Bạn có muốn đăng nhập ngay không?'
                );

                if (confirmLogin) {
                    window.location.href = "{{ route('login') }}";
                }
            }
        </script>
    @endguest
    {{-- PRODUCT DETAIL JAVASCRIPT --}}
    <script src="{{ asset('js/product-detail.js') }}" defer></script>


    {{-- VARIANT / GALLERY / QUANTITY --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | CHỌN BIẾN THỂ
            |--------------------------------------------------------------------------
            */

            const variants = document.querySelectorAll('.pd-variant');

            const priceElement = document.getElementById('pdPrice');
            const oldPriceElement = document.getElementById('pdOldPrice');
            const savingElement = document.querySelector('.pd-saving');

            const selectedVariantElement = document.getElementById('pdSelectedVariant');
            const stockElement = document.getElementById('pdStock');
            const skuElement = document.getElementById('pdSku');

            const mainImage = document.getElementById('pdMainImage');
            const quantityInput = document.getElementById('pdQuantity');

            const addCartButton = document.getElementById('pdAddCart');
            const buyNowButton = document.getElementById('pdBuyNow');

            function formatPrice(price) {
                return new Intl.NumberFormat('vi-VN').format(Number(price)) + '₫';
            }

            function selectVariant(button) {

                variants.forEach(item => item.classList.remove('active'));

                button.classList.add('active');

                const name = button.dataset.name;
                const price = Number(button.dataset.price || 0);
                const oldPrice = Number(button.dataset.oldPrice || 0);
                const stock = Number(button.dataset.stock || 0);
                const sku = button.dataset.sku || 'Đang cập nhật';
                const image = button.dataset.image;

                // Tên biến thể.
                selectedVariantElement.textContent = name;

                // Giá bán.
                priceElement.textContent = formatPrice(price);

                // Giá gốc và giảm giá.
                if (oldPrice > price) {

                    oldPriceElement.textContent = formatPrice(oldPrice);
                    oldPriceElement.style.display = '';

                    if (savingElement) {
                        savingElement.textContent = 'Tiết kiệm ' + formatPrice(oldPrice - price);
                        savingElement.style.display = '';
                    }

                } else {

                    oldPriceElement.style.display = 'none';

                    if (savingElement) {
                        savingElement.style.display = 'none';
                    }

                }

                // SKU.
                skuElement.textContent = sku;

                // Tồn kho.
                if (stock > 0) {

                    stockElement.innerHTML =
                        '<i class="bi bi-box-seam"></i> Còn hàng (' +
                        stock + ' sản phẩm sẵn sàng giao ngay)';

                } else {

                    stockElement.innerHTML =
                        '<i class="bi bi-x-circle"></i> Hết hàng';

                }

                // Giới hạn số lượng.
                quantityInput.max = Math.max(1, stock);
                quantityInput.value = 1;

                // Trạng thái nút mua hàng.
                addCartButton.disabled = stock <= 0;
                buyNowButton.disabled = stock <= 0;

                // Đổi ảnh chính theo biến thể nếu có.
                if (image && mainImage) {
                    mainImage.src = image;

                    document.querySelectorAll('.pd-thumbnail').forEach(item => {
                        item.classList.remove('active');
                    });
                }

                // Cập nhật thông tin trong modal đánh giá.
                const reviewVariant = document.getElementById('pdReviewVariant');
                const reviewPrice = document.getElementById('pdReviewProductPrice');
                const reviewImage = document.getElementById('pdReviewProductImage');

                if (reviewVariant) {
                    reviewVariant.textContent = name;
                }

                if (reviewPrice) {
                    reviewPrice.textContent = formatPrice(price);
                }

                if (reviewImage && image) {
                    reviewImage.src = image;
                }

            }

            variants.forEach(button => {

                button.addEventListener('click', function() {
                    selectVariant(this);
                });

            });


            /*
            |--------------------------------------------------------------------------
            | CHỌN ẢNH SẢN PHẨM
            |--------------------------------------------------------------------------
            */

            const thumbnails = document.querySelectorAll('.pd-thumbnail');

            thumbnails.forEach(button => {

                button.addEventListener('click', function() {

                    const image = this.dataset.image;

                    if (!image || !mainImage) return;

                    mainImage.src = image;

                    thumbnails.forEach(item => {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');

                });

            });


            /*
            |--------------------------------------------------------------------------
            | TĂNG / GIẢM SỐ LƯỢNG
            |--------------------------------------------------------------------------
            */

            const decreaseButton = document.getElementById('pdDecrease');
            const increaseButton = document.getElementById('pdIncrease');

            decreaseButton?.addEventListener('click', function() {

                let quantity = Number(quantityInput.value);
                quantityInput.value = Math.max(1, quantity - 1);

            });

            increaseButton?.addEventListener('click', function() {

                let quantity = Number(quantityInput.value);
                let max = Number(quantityInput.max);

                if (quantity < max) {
                    quantityInput.value = quantity + 1;
                }

            });


            /*
            |--------------------------------------------------------------------------
            | CHIA SẺ SẢN PHẨM
            |--------------------------------------------------------------------------
            */

            document.getElementById('pdShare')?.addEventListener('click', function() {

                if (navigator.share) {

                    navigator.share({
                        title: document.title,
                        url: window.location.href
                    });

                } else if (navigator.clipboard) {

                    navigator.clipboard.writeText(window.location.href)
                        .then(() => alert('Đã sao chép liên kết sản phẩm!'));

                }

            });


            /*
            |--------------------------------------------------------------------------
            | TAB CHI TIẾT
            |--------------------------------------------------------------------------
            */

            const tabs = document.querySelectorAll('.pd-detail-tab');

            const tabContents = {
                specifications: document.getElementById('pdTabSpecifications'),
                description: document.getElementById('pdTabDescription'),
                reviews: document.getElementById('pdTabReviews')
            };

            tabs.forEach(tab => {

                tab.addEventListener('click', function() {

                    const target = this.dataset.tab;

                    tabs.forEach(item => item.classList.remove('active'));

                    Object.values(tabContents).forEach(content => {
                        content?.classList.remove('active');
                    });

                    this.classList.add('active');

                    tabContents[target]?.classList.add('active');

                });

            });

            document.querySelectorAll('.et-quantity-control').forEach(function(control) {

                const input = control.querySelector('.et-qty-input');
                const form = control.closest('.et-quantity-form');

                if (!input || !form) return;

                control.querySelectorAll('.et-qty-btn').forEach(function(button) {

                    button.addEventListener('click', function() {

                        let quantity = parseInt(input.value) || 1;

                        if (button.dataset.action === 'minus') {
                            quantity = Math.max(1, quantity - 1);
                        }

                        if (button.dataset.action === 'plus') {
                            quantity += 1;
                        }

                        input.value = quantity;

                        form.requestSubmit();

                    });

                });

                input.addEventListener('change', function() {

                    let quantity = parseInt(input.value) || 1;

                    input.value = Math.max(1, quantity);

                    form.requestSubmit();

                });

            });


        });
    </script>

@endsection
