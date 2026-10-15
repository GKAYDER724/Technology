
/**
 * ElectroStore - Product Detail Interactions
 * File: public/js/product-detail.js
 *
 * JavaScript riêng cho trang chi tiết sản phẩm.
 * Các thao tác giỏ hàng và đánh giá hiện là demo frontend,
 * chưa lưu vào database.
 */

document.addEventListener('DOMContentLoaded', function () {
    const page = document.querySelector('.product-detail-page');

    // Không chạy trên các trang không phải chi tiết sản phẩm.
    if (!page) return;

    const $ = (selector, root = page) => root.querySelector(selector);
    const $$ = (selector, root = page) => [...root.querySelectorAll(selector)];

    const money = value =>
        new Intl.NumberFormat('vi-VN').format(Number(value) || 0) + '₫';

    const notify = (message, type = 'info') => {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        } else {
            window.alert(message);
        }
    };

    // ========================================
    // 1. PRODUCT IMAGE GALLERY
    // ========================================

    const mainImage = $('#pdMainImage');
    const thumbnails = $$('.pd-thumbnail');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            if (!mainImage || !this.dataset.image) return;

            mainImage.src = this.dataset.image;

            thumbnails.forEach(item => {
                item.classList.remove('active');
            });

            this.classList.add('active');

            const reviewProductImage = document.getElementById(
                'pdReviewProductImage'
            );

            if (reviewProductImage) {
                reviewProductImage.src = this.dataset.image;
            }
        });
    });

    // ========================================
    // 2. PRODUCT VARIANTS, PRICE AND STOCK
    // ========================================

    const variants = $$('.pd-variant');
    const priceElement = $('#pdPrice');
    const oldPriceElement = $('#pdOldPrice');
    const selectedVariantElement = $('#pdSelectedVariant');
    const stockElement = $('#pdStock');
    const quantityInput = $('#pdQuantity');

    const reviewVariantElement = document.getElementById(
        'pdReviewVariant'
    );

    const reviewPriceElement = document.getElementById(
        'pdReviewProductPrice'
    );

    const reviewProductImage = document.getElementById(
        'pdReviewProductImage'
    );

    const productName = page.dataset.productName || 'Sản phẩm';

    const initialVariant = $('.pd-variant.active') || variants[0];

    let selectedPrice = initialVariant
        ? Number(initialVariant.dataset.price) || 0
        : 0;

    function getStock(variant) {
        const match = (variant?.dataset.stock || '').match(/\d+/);
        return match ? Number(match[0]) : 1;
    }

    function getSelectedVariant() {
        return $('.pd-variant.active');
    }

    function updateVariant(variant) {
        if (!variant) return;

        variants.forEach(item => {
            item.classList.toggle('active', item === variant);
        });

        selectedPrice = Number(variant.dataset.price) || 0;

        const variantName = variant.dataset.name || '';
        const stockText = variant.dataset.stock || 'Còn hàng';
        const maxStock = getStock(variant);

        if (priceElement) {
            priceElement.textContent = money(selectedPrice);
        }

        if (selectedVariantElement) {
            selectedVariantElement.textContent =
                '256GB - ' + variantName;
        }

        if (stockElement) {
            stockElement.replaceChildren();

            const icon = document.createElement('i');
            icon.className = 'bi bi-box-seam';

            stockElement.append(
                icon,
                document.createTextNode(
                    ' ' + stockText +
                    ' sản phẩm sẵn sàng giao ngay'
                )
            );
        }

        if (quantityInput) {
            quantityInput.max = String(maxStock);
            quantityInput.value = String(
                Math.min(
                    maxStock,
                    Math.max(1, Number(quantityInput.value) || 1)
                )
            );
        }

        if (reviewVariantElement) {
            reviewVariantElement.textContent =
                '256GB - ' + variantName;
        }

        if (reviewPriceElement) {
            reviewPriceElement.textContent = money(selectedPrice);
        }

        if (reviewProductImage && mainImage) {
            reviewProductImage.src = mainImage.src;
        }
    }

    variants.forEach(variant => {
        variant.addEventListener('click', () => {
            updateVariant(variant);
        });
    });

    // ========================================
    // 3. QUANTITY
    // ========================================

    const decreaseButton = $('#pdDecrease');
    const increaseButton = $('#pdIncrease');

    function updateQuantity(delta) {
        if (!quantityInput) return;

        const min = Number(quantityInput.min) || 1;
        const max = Number(quantityInput.max) || 1;
        const current = Number(quantityInput.value) || 1;
        const next = Math.max(min, Math.min(max, current + delta));

        if (next === current && delta > 0) {
            notify(
                `Bạn chỉ có thể chọn tối đa ${max} sản phẩm.`,
                'info'
            );
        }

        quantityInput.value = String(next);
    }

    decreaseButton?.addEventListener('click', () => {
        updateQuantity(-1);
    });

    increaseButton?.addEventListener('click', () => {
        updateQuantity(1);
    });

    // ========================================
    // 4. PRODUCT DETAIL TABS
    // ========================================

    const tabs = $$('.pd-detail-tab');

    const tabContents = {
        specifications: $('#pdTabSpecifications'),
        description: $('#pdTabDescription'),
        reviews: $('#pdTabReviews')
    };

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = tabContents[this.dataset.tab];

            if (!target) return;

            tabs.forEach(item => {
                const active = item === this;

                item.classList.toggle('active', active);
                item.setAttribute(
                    'aria-selected',
                    String(active)
                );
            });

            Object.values(tabContents).forEach(content => {
                content?.classList.remove('active');
            });

            target.classList.add('active');
        });
    });

    // ========================================
    // 5. FAVORITE
    // ========================================

    const favoriteButton = $('#pdFavorite');

    favoriteButton?.addEventListener('click', function () {
        const icon = $('i', this);

        if (!icon) return;

        const isFavorite = icon.classList.contains('bi-heart-fill');

        icon.className = isFavorite
            ? 'bi bi-heart'
            : 'bi bi-heart-fill';

        this.classList.toggle('is-favorite', !isFavorite);

        notify(
            isFavorite
                ? 'Đã bỏ sản phẩm khỏi danh sách yêu thích.'
                : 'Đã thêm sản phẩm vào danh sách yêu thích.',
            'success'
        );
    });

    // ========================================
    // 6. SHARE PRODUCT
    // ========================================

    $('#pdShare')?.addEventListener('click', async function () {
        try {
            if (navigator.share) {
                await navigator.share({
                    title: document.title,
                    url: window.location.href
                });
            } else if (navigator.clipboard?.writeText) {
                await navigator.clipboard.writeText(
                    window.location.href
                );

                notify('Đã sao chép liên kết sản phẩm.', 'success');
            } else {
                window.prompt(
                    'Sao chép liên kết sản phẩm:',
                    window.location.href
                );
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Không thể chia sẻ sản phẩm:', error);
                notify('Không thể chia sẻ sản phẩm lúc này.', 'danger');
            }
        }
    });

    // ========================================
    // 7. ADD TO CART - FRONTEND DEMO
    // ========================================

    function getSelectedProduct() {
        const variant = getSelectedVariant();

        return {
            name: productName,
            variant: variant?.dataset.name || '',
            price: selectedPrice,
            quantity: Number(quantityInput?.value) || 1
        };
    }

    $('#pdAddCart')?.addEventListener('click', function () {
        const product = getSelectedProduct();

        notify(
            `Sản phẩm: ${product.name}\n` +
            `Phiên bản: ${product.variant}\n` +
            `Số lượng: ${product.quantity}\n` +
            `Giá: ${money(product.price)}\n\n` +
            'Đây là bản demo. Chưa lưu vào giỏ hàng hệ thống.',
            'info'
        );
    });

    // ========================================
    // 8. BUY NOW - FRONTEND DEMO
    // ========================================

    $('#pdBuyNow')?.addEventListener('click', function () {
        const product = getSelectedProduct();

        notify(
            `Bạn đã chọn mua ${product.name}.\n` +
            `Phiên bản: ${product.variant}\n` +
            `Số lượng: ${product.quantity}\n` +
            `Tạm tính: ${money(product.price * product.quantity)}\n\n` +
            'Chức năng thanh toán chưa được kết nối.',
            'info'
        );
    });

    // ========================================
    // 9. REVIEW MODAL
    // ========================================

    const reviewModal = document.getElementById('pdReviewModal');
    const openReviewButton = document.getElementById('pdOpenReviewModal');
    const closeReviewButton = document.getElementById('pdCloseReviewModal');
    const reviewForm = document.getElementById('pdReviewForm');

    if (!reviewModal || !reviewForm) return;

    const reviewRating = document.getElementById('pdReviewRating');
    const reviewRatingCaption = document.getElementById(
        'pdReviewRatingCaption'
    );

    const starPicker = document.getElementById('pdReviewStarPicker');
    const reviewStars = [...document.querySelectorAll('.pd-review-star')];

    const reviewTitle = document.getElementById('pdReviewTitle');
    const reviewContent = document.getElementById('pdReviewContent');
    const reviewImages = document.getElementById('pdReviewImages');
    const imagePreview = document.getElementById('pdReviewImagePreview');
    const reviewConfirmed = document.getElementById('pdReviewConfirmed');

    const ratingError = document.getElementById('pdReviewRatingError');
    const titleError = document.getElementById('pdReviewTitleError');
    const contentError = document.getElementById('pdReviewContentError');
    const imagesError = document.getElementById('pdReviewImagesError');
    const confirmError = document.getElementById('pdReviewConfirmError');

    const ratingLabels = {
        1: 'Rất không hài lòng',
        2: 'Không hài lòng',
        3: 'Bình thường',
        4: 'Hài lòng',
        5: 'Tuyệt vời - Rất hài lòng'
    };

    let selectedReviewImages = [];
    let reviewObjectUrls = [];

    function openReview() {
        const activeVariant = getSelectedVariant();

        if (activeVariant) {
            updateVariant(activeVariant);
        }

        reviewModal.classList.add('is-open');
        reviewModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('pd-review-modal-open');

        window.setTimeout(() => reviewTitle?.focus(), 100);
    }

    function closeReview() {
        reviewModal.classList.remove('is-open');
        reviewModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('pd-review-modal-open');
    }

    openReviewButton?.addEventListener('click', openReview);
    closeReviewButton?.addEventListener('click', closeReview);

    document.querySelectorAll('[data-close-review]').forEach(button => {
        button.addEventListener('click', closeReview);
    });

    document.addEventListener('keydown', event => {
        if (
            event.key === 'Escape' &&
            reviewModal.classList.contains('is-open')
        ) {
            closeReview();
        }
    });

    // ========================================
    // 10. REVIEW STAR PICKER
    // ========================================

    function updateReviewStars(value) {
        const rating = Math.max(1, Math.min(5, Number(value) || 5));

        if (reviewRating) {
            reviewRating.value = String(rating);
        }

        if (reviewRatingCaption) {
            reviewRatingCaption.textContent = ratingLabels[rating];
        }

        reviewStars.forEach(star => {
            const starValue = Number(star.dataset.star);
            const active = starValue <= rating;

            star.classList.toggle('active', active);
            star.setAttribute(
                'aria-pressed',
                String(starValue === rating)
            );
        });
    }

    reviewStars.forEach(star => {
        star.addEventListener('click', () => {
            updateReviewStars(star.dataset.star);

            if (ratingError) ratingError.textContent = '';
        });

        star.addEventListener('mouseenter', () => {
            const rating = Number(star.dataset.star);

            reviewStars.forEach(item => {
                item.classList.toggle(
                    'active',
                    Number(item.dataset.star) <= rating
                );
            });
        });
    });

    starPicker?.addEventListener('mouseleave', () => {
        updateReviewStars(reviewRating?.value);
    });

    // ========================================
    // 11. REVIEW CHARACTER COUNTERS
    // ========================================

    reviewTitle?.addEventListener('input', function () {
        const counter = document.getElementById('pdReviewTitleCount');

        if (counter) {
            counter.textContent = String(this.value.length);
        }

        if (titleError) titleError.textContent = '';
    });

    reviewContent?.addEventListener('input', function () {
        const counter = document.getElementById('pdReviewContentCount');

        if (counter) {
            counter.textContent = String(this.value.length);
        }

        if (contentError) contentError.textContent = '';
    });

    // ========================================
    // 12. REVIEW IMAGE UPLOAD AND PREVIEW
    // ========================================

    function clearReviewObjectUrls() {
        reviewObjectUrls.forEach(url => URL.revokeObjectURL(url));
        reviewObjectUrls = [];
    }

    function renderReviewImages() {
        if (!imagePreview) return;

        clearReviewObjectUrls();
        imagePreview.replaceChildren();

        selectedReviewImages.forEach((file, index) => {
            const url = URL.createObjectURL(file);
            reviewObjectUrls.push(url);

            const item = document.createElement('div');
            item.className = 'pd-review-image-item';

            const image = document.createElement('img');
            image.src = url;
            image.alt = `Ảnh đánh giá ${index + 1}`;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'pd-review-image-remove';
            remove.setAttribute(
                'aria-label',
                `Xóa ảnh ${index + 1}`
            );

            const icon = document.createElement('i');
            icon.className = 'bi bi-x';

            remove.appendChild(icon);

            remove.addEventListener('click', () => {
                selectedReviewImages.splice(index, 1);
                renderReviewImages();
            });

            item.append(image, remove);
            imagePreview.appendChild(item);
        });
    }

    reviewImages?.addEventListener('change', function () {
        const newFiles = Array.from(this.files || []);

        if (imagesError) imagesError.textContent = '';

        if (selectedReviewImages.length + newFiles.length > 5) {
            if (imagesError) {
                imagesError.textContent = 'Bạn chỉ được tải tối đa 5 ảnh.';
            }

            this.value = '';
            return;
        }

        const invalidFile = newFiles.find(file => {
            return (
                !['image/jpeg', 'image/png', 'image/webp'].includes(file.type) ||
                file.size > 5 * 1024 * 1024
            );
        });

        if (invalidFile) {
            if (imagesError) {
                imagesError.textContent =
                    'Ảnh phải là JPG, PNG hoặc WEBP và không quá 5MB.';
            }

            this.value = '';
            return;
        }

        selectedReviewImages.push(...newFiles);
        renderReviewImages();

        // Cho phép chọn lại cùng một file ở lần tiếp theo.
        this.value = '';
    });

    // ========================================
    // 13. REVIEW FORM VALIDATION
    // ========================================

    function clearReviewErrors() {
        [
            ratingError,
            titleError,
            contentError,
            imagesError,
            confirmError
        ].forEach(element => {
            if (element) element.textContent = '';
        });
    }

    reviewForm.addEventListener('submit', function (event) {
        event.preventDefault();
        clearReviewErrors();

        let valid = true;

        const title = reviewTitle?.value.trim() || '';
        const content = reviewContent?.value.trim() || '';
        const rating = Number(reviewRating?.value) || 0;

        if (rating < 1 || rating > 5) {
            if (ratingError) {
                ratingError.textContent = 'Vui lòng chọn số sao đánh giá.';
            }

            valid = false;
        }

        if (!title) {
            if (titleError) {
                titleError.textContent = 'Vui lòng nhập tiêu đề đánh giá.';
            }

            valid = false;
        }

        if (title.length > 100) {
            if (titleError) {
                titleError.textContent =
                    'Tiêu đề không được vượt quá 100 ký tự.';
            }

            valid = false;
        }

        if (content.length < 10) {
            if (contentError) {
                contentError.textContent =
                    'Nội dung đánh giá phải có ít nhất 10 ký tự.';
            }

            valid = false;
        }

        if (content.length > 1500) {
            if (contentError) {
                contentError.textContent =
                    'Nội dung không được vượt quá 1500 ký tự.';
            }

            valid = false;
        }

        if (!reviewConfirmed?.checked) {
            if (confirmError) {
                confirmError.textContent =
                    'Vui lòng xác nhận trước khi gửi đánh giá.';
            }

            valid = false;
        }

        if (!valid) return;

        // Dữ liệu demo: chưa gửi lên Laravel backend.
        const reviewData = {
            product: productName,
            variant: reviewVariantElement?.textContent || '',
            rating: rating,
            title: title,
            content: content,
            images: selectedReviewImages.map(file => file.name)
        };

        console.log('Review demo:', reviewData);

        notify(
            `Bạn đã hoàn thành biểu mẫu đánh giá!\n\n` +
            `Số sao: ${reviewData.rating}/5\n` +
            `Tiêu đề: ${reviewData.title}\n\n` +
            'Đây là bản demo. Đánh giá chưa được lưu vào hệ thống.',
            'success'
        );

        closeReview();
    });

    // Khởi tạo giao diện theo phiên bản đang được chọn.
    if (initialVariant) {
        updateVariant(initialVariant);
    }

    updateReviewStars(reviewRating?.value || 5);
});
