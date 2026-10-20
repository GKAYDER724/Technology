
/**
 * ElectroStore - Frontend Interactive Scripts
 */

document.addEventListener('DOMContentLoaded', function () {

    // 1. Toast Notification Helper
    window.showToast = function (message, type = 'success') {
        let container = document.getElementById('toast-container');

        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.position = 'fixed';
            container.style.bottom = '24px';
            container.style.right = '24px';
            container.style.zIndex = '9999';
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.gap = '10px';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');

        const bgColor = type === 'success'
            ? '#10b981'
            : (type === 'danger' ? '#ef4444' : '#2563eb');

        const icon = type === 'success'
            ? 'bi-check-circle-fill'
            : (type === 'danger'
                ? 'bi-x-circle-fill'
                : 'bi-info-circle-fill');

        toast.style.backgroundColor = bgColor;
        toast.style.color = '#ffffff';
        toast.style.padding = '12px 20px';
        toast.style.borderRadius = '8px';
        toast.style.boxShadow = '0 10px 15px -3px rgba(0,0,0,0.2)';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '10px';
        toast.style.fontSize = '0.9rem';
        toast.style.fontWeight = '500';
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';

        // Dùng textContent để tránh chèn HTML từ message.
        const toastIcon = document.createElement('i');
        toastIcon.className = `bi ${icon} fs-5`;

        const toastText = document.createElement('span');
        toastText.textContent = message;

        toast.append(toastIcon, toastText);
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';

            setTimeout(() => toast.remove(), 300);
        }, 3500);
    };


    // 2. Product Detail Image Gallery
    const mainGalleryImg = document.getElementById('main-gallery-image');
    const galleryThumbs = document.querySelectorAll('.product-gallery-thumb');

    if (mainGalleryImg && galleryThumbs.length > 0) {
        galleryThumbs.forEach(thumb => {
            thumb.addEventListener('click', function () {
                galleryThumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const targetSrc = this.getAttribute('data-img');

                if (targetSrc) {
                    mainGalleryImg.src = targetSrc;
                }
            });
        });
    }


    // 3. Variant Choice Selectors
    const variantButtons = document.querySelectorAll('.variant-choice-btn');

    variantButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const group = this.getAttribute('data-group');

            document.querySelectorAll(
                `.variant-choice-btn[data-group="${group}"]`
            ).forEach(button => {
                button.classList.remove(
                    'active',
                    'border-primary',
                    'bg-primary-subtle',
                    'text-primary'
                );

                button.classList.add('border-secondary-subtle');
            });

            this.classList.add(
                'active',
                'border-primary',
                'bg-primary-subtle',
                'text-primary'
            );

            this.classList.remove('border-secondary-subtle');
        });
    });


    // 4. Quantity Adjustments (+ / -)
    document.querySelectorAll('.qty-control').forEach(control => {
        const minusBtn = control.querySelector('.qty-minus');
        const plusBtn = control.querySelector('.qty-plus');
        const input = control.querySelector('.qty-input');

        if (minusBtn && plusBtn && input) {
            minusBtn.addEventListener('click', () => {
                let val = parseInt(input.value, 10) || 1;

                if (val > 1) {
                    input.value = val - 1;
                    triggerCartRecalc();
                }
            });

            plusBtn.addEventListener('click', () => {
                let val = parseInt(input.value, 10) || 1;
                const max = parseInt(input.max, 10);

                if (!Number.isNaN(max) && val >= max) {
                    window.showToast(
                        `Bạn chỉ có thể chọn tối đa ${max} sản phẩm.`,
                        'info'
                    );
                    return;
                }

                input.value = val + 1;
                triggerCartRecalc();
            });

            input.addEventListener('change', () => {
                let val = parseInt(input.value, 10) || 1;
                const min = parseInt(input.min, 10) || 1;
                const max = parseInt(input.max, 10);

                val = Math.max(min, val);

                if (!Number.isNaN(max)) {
                    val = Math.min(val, max);
                }

                input.value = val;
            });
        }
    });

    function triggerCartRecalc() {
        const totalSpan = document.getElementById('cart-subtotal-display');

        if (totalSpan) {
            window.showToast(
                'Đã cập nhật số lượng trong giỏ hàng',
                'info'
            );
        }
    }


    // 5. Star Rating Selector (Review Page)
    const starPicker = document.getElementById('star-rating-picker');

    if (starPicker) {
        const stars = starPicker.querySelectorAll('.rating-star-icon');
        const scoreInput = document.getElementById('selected-star-score');
        const scoreLabel = document.getElementById('selected-star-label');

        const labels = {
            1: 'Rất tệ (1/5)',
            2: 'Tệ (2/5)',
            3: 'Bình thường (3/5)',
            4: 'Hài lòng (4/5)',
            5: 'Tuyệt vời, cực kỳ hài lòng (5/5)'
        };

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const val = parseInt(
                    this.getAttribute('data-score'),
                    10
                );

                if (scoreInput) {
                    scoreInput.value = val;
                }

                if (scoreLabel && labels[val]) {
                    scoreLabel.textContent = labels[val];
                }

                stars.forEach(s => {
                    const score = parseInt(
                        s.getAttribute('data-score'),
                        10
                    );

                    if (score <= val) {
                        s.classList.remove('bi-star', 'text-muted');
                        s.classList.add('bi-star-fill', 'text-warning');
                    } else {
                        s.classList.remove(
                            'bi-star-fill',
                            'text-warning'
                        );

                        s.classList.add('bi-star', 'text-muted');
                    }
                });
            });
        });
    }


    // 6. Add to Cart Actions
    document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const productName =
                this.getAttribute('data-name') || 'Sản phẩm';

            window.showToast(
                `Đã thêm "${productName}" vào giỏ hàng!`,
                'success'
            );

            const badge = document.querySelector('.badge-counter');

            if (badge) {
                const current = parseInt(badge.textContent, 10) || 0;
                badge.textContent = current + 1;
            }
        });
    });


    // 7. Apply Coupon Button
    const applyCouponBtn = document.getElementById('btn-apply-coupon');

    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function () {
            const input = document.getElementById('coupon-input');
            const code = input
                ? input.value.trim().toUpperCase()
                : '';

            if (!code) {
                window.showToast(
                    'Vui lòng nhập mã giảm giá',
                    'danger'
                );
                return;
            }

            if (code === 'ELECTRO500K' || code === 'TECHWEEKEND') {
                window.showToast(
                    `Áp dụng mã ${code} thành công! Giảm ngay 500.000₫`,
                    'success'
                );
            } else {
                window.showToast(
                    `Mã ưu đãi "${code}" đã được kích hoạt!`,
                    'success'
                );
            }
        });
    }


    // 8. Cancel Order Form
    const cancelForm = document.getElementById('cancel-order-form');

    if (cancelForm) {
        cancelForm.addEventListener('submit', function (e) {
            e.preventDefault();

            window.showToast(
                'Yêu cầu hủy đơn hàng đã được ghi nhận thành công!',
                'success'
            );

            setTimeout(() => {
                window.location.href = '/orders';
            }, 1200);
        });
    }


    // 9. Review Form
    const reviewForm = document.getElementById('submit-review-form');

    if (reviewForm) {
        reviewForm.addEventListener('submit', function (e) {
            e.preventDefault();

            window.showToast(
                'Cảm ơn bạn đã gửi đánh giá sản phẩm!',
                'success'
            );

            setTimeout(() => {
                window.location.reload();
            }, 1200);
        });
    }

// 10. Profile Update Form
const profileForm = document.getElementById('profile-update-form');

if (profileForm) {
    profileForm.addEventListener('submit', function () {
        // Để Laravel nhận form và cập nhật dữ liệu
    });
}


    // 11. Checkout Order Form
    const checkoutForm = document.getElementById('checkout-order-form');

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
            e.preventDefault();

            window.showToast(
                'Đặt hàng thành công! Mã đơn: #DH-20261010-891',
                'success'
            );

            setTimeout(() => {
                window.location.href = '/orders/DH-20261010-891';
            }, 1200);
        });
    }


    // 12. Account Dropdown Menu
    const accountWrapper = document.querySelector('.et-account-wrapper');
    const accountToggle = document.getElementById('etAccountToggle');

    if (accountWrapper && accountToggle) {
        const accountDropdown = document.getElementById(
            'etAccountDropdown'
        );

        function closeAccountDropdown() {
            accountWrapper.classList.remove('is-open');

            accountToggle.setAttribute('aria-expanded', 'false');
        }

        accountToggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = accountWrapper.classList.toggle('is-open');

            accountToggle.setAttribute(
                'aria-expanded',
                String(isOpen)
            );
        });

        if (accountDropdown) {
            accountDropdown.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        }

        document.addEventListener('click', function (event) {
            if (!accountWrapper.contains(event.target)) {
                closeAccountDropdown();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeAccountDropdown();
                accountToggle.focus();
            }
        });
    }


    // 13. Shopping Cart Interactions
    const cartProducts = document.getElementById('cart-products');
    const cartEmpty = document.getElementById('cart-empty');
    const cartSidebar = document.getElementById('cart-sidebar');

    if (cartProducts) {
        const couponApplied = document.getElementById('coupon-applied');
        const couponInput = document.getElementById('coupon-input');
        const appliedCode = document.getElementById('applied-code');
        const appliedDescription = document.getElementById('applied-description');

        let activeCoupon = '';

        const money = value =>
            new Intl.NumberFormat('vi-VN').format(value) + '₫';

        function getCartRows() {
            return [...cartProducts.querySelectorAll('.et-cart-product')];
        }

        function getSubtotal() {
            return getCartRows().reduce((sum, row) => {
                const price = Number(row.dataset.price) || 0;
                const qty = Number(
                    row.querySelector('.et-qty-input')?.value
                ) || 1;

                return sum + price * qty;
            }, 0);
        }

        function getDiscount(subtotal) {
            if (activeCoupon === 'TECH500' && subtotal >= 5000000) {
                return 500000;
            }

            if (activeCoupon === 'VIPMEMBER' && subtotal >= 20000000) {
                return 1000000;
            }

            return 0;
        }

        function renderCart() {
            const rows = getCartRows();
            const subtotal = getSubtotal();
            const discount = getDiscount(subtotal);
            const shipping = subtotal === 0 || subtotal >= 5000000
                ? 0
                : 30000;

            const total = Math.max(0, subtotal + shipping - discount);

            const quantity = rows.reduce((sum, row) => {
                return sum + (
                    Number(row.querySelector('.et-qty-input')?.value) || 1
                );
            }, 0);

            document.getElementById('cart-item-count').textContent = quantity;

            const subtotalEl = document.getElementById('cart-subtotal');
            const shippingEl = document.getElementById('cart-shipping');
            const discountEl = document.getElementById('cart-discount');
            const totalEl = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('checkout-button');

            if (subtotalEl) subtotalEl.textContent = money(subtotal);

            if (shippingEl) {
                shippingEl.textContent = shipping === 0
                    ? 'Miễn phí'
                    : money(shipping);
            }

            if (discountEl) {
                discountEl.textContent = '-' + money(discount);
            }

            if (totalEl) totalEl.textContent = money(total);

            rows.forEach(row => {
                const price = Number(row.dataset.price) || 0;
                const qty = Number(
                    row.querySelector('.et-qty-input')?.value
                ) || 1;

                const lineTotal = row.querySelector('.et-line-total');

                if (lineTotal) {
                    lineTotal.textContent = money(price * qty);
                }
            });

            const isEmpty = rows.length === 0;

            if (cartEmpty) cartEmpty.hidden = !isEmpty;
            if (cartSidebar) cartSidebar.hidden = isEmpty;

            if (checkoutBtn) {
                checkoutBtn.classList.toggle('is-disabled', isEmpty);
                checkoutBtn.setAttribute(
                    'aria-disabled',
                    String(isEmpty)
                );
            }

            document.querySelectorAll('.et-qty-minus').forEach(btn => {
                const input = btn
                    .closest('.et-cart-quantity')
                    ?.querySelector('.et-qty-input');

                btn.disabled = !input || Number(input.value) <= 1;
            });

            document.querySelectorAll('.et-qty-plus').forEach(btn => {
                const input = btn
                    .closest('.et-cart-quantity')
                    ?.querySelector('.et-qty-input');

                btn.disabled = !input || Number(input.value) >= 99;
            });

            const heading = document.querySelector('.et-cart-heading h1');

            if (heading) {
                heading.innerHTML =
                    `Giỏ Hàng Mua Sắm (<span id="cart-item-count">${quantity}</span> sản phẩm)`;
            }

            if (couponApplied && activeCoupon) {
                const eligible =
                    (activeCoupon === 'TECH500' && subtotal >= 5000000) ||
                    (activeCoupon === 'VIPMEMBER' && subtotal >= 20000000) ||
                    activeCoupon === 'FREESHIP';

                if (!eligible) {
                    couponApplied.hidden = false;

                    if (appliedDescription) {
                        appliedDescription.textContent =
                            'Đơn hàng chưa đạt điều kiện áp dụng mã này.';
                    }
                } else if (appliedDescription) {
                    if (activeCoupon === 'TECH500') {
                        appliedDescription.textContent =
                            'Giảm ngay 500.000₫ cho đơn hàng từ 5.000.000₫';
                    } else if (activeCoupon === 'VIPMEMBER') {
                        appliedDescription.textContent =
                            'Giảm 1.000.000₫ cho đơn từ 20.000.000₫';
                    } else {
                        appliedDescription.textContent =
                            'Miễn phí vận chuyển toàn quốc';
                    }
                }
            }
        }

        function applyCoupon(code) {
            code = code.trim().toUpperCase();

            if (!code) {
                window.showToast?.('Vui lòng nhập mã giảm giá.', 'danger');
                return;
            }

            const subtotal = getSubtotal();

            if (code === 'TECH500' && subtotal < 5000000) {
                window.showToast?.(
                    'Đơn hàng cần đạt 5.000.000₫ để dùng mã TECH500.',
                    'danger'
                );
                return;
            }

            if (code === 'VIPMEMBER' && subtotal < 20000000) {
                window.showToast?.(
                    'Mã VIPMEMBER áp dụng cho đơn từ 20.000.000₫.',
                    'danger'
                );
                return;
            }

            if (!['TECH500', 'FREESHIP', 'VIPMEMBER'].includes(code)) {
                window.showToast?.('Mã giảm giá không hợp lệ.', 'danger');
                return;
            }

            activeCoupon = code;

            if (couponApplied) couponApplied.hidden = false;
            if (appliedCode) appliedCode.textContent = code;

            renderCart();

            window.showToast?.(
                `Đã áp dụng mã ${code} thành công!`,
                'success'
            );
        }

        // Increase, decrease and remove products.
        cartProducts.addEventListener('click', function (event) {
            const minus = event.target.closest('.et-qty-minus');
            const plus = event.target.closest('.et-qty-plus');
            const remove = event.target.closest('.et-cart-remove');

            if (minus || plus) {
                const row = event.target.closest('.et-cart-product');
                const input = row?.querySelector('.et-qty-input');

                if (!input) return;

                let qty = Number(input.value) || 1;

                if (minus) qty = Math.max(1, qty - 1);
                if (plus) qty = Math.min(99, qty + 1);

                input.value = qty;
                renderCart();
            }

            if (remove) {
                const row = remove.closest('.et-cart-product');

                if (row) {
                    row.remove();
                    renderCart();

                    window.showToast?.(
                        'Đã xóa sản phẩm khỏi giỏ hàng.',
                        'success'
                    );
                }
            }
        });

        // Apply coupon using input.
        document.getElementById('btn-apply-coupon')
            ?.addEventListener('click', function () {
                applyCoupon(couponInput?.value || '');
            });

        couponInput?.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                applyCoupon(couponInput.value);
            }
        });

        // Apply coupon from suggested coupon list.
        document.querySelectorAll('.et-coupon-option').forEach(button => {
            button.addEventListener('click', function () {
                const code = this.dataset.code || '';

                if (couponInput) couponInput.value = code;

                applyCoupon(code);
            });
        });

        // Remove active coupon.
        document.getElementById('remove-coupon')
            ?.addEventListener('click', function () {
                activeCoupon = '';

                if (couponApplied) couponApplied.hidden = true;
                if (couponInput) couponInput.value = '';

                renderCart();

                window.showToast?.(
                    'Đã bỏ mã giảm giá.',
                    'info'
                );
            });

        // Clear the entire cart.
        document.getElementById('clear-cart')
            ?.addEventListener('click', function () {
                const rows = getCartRows();

                if (rows.length === 0) return;

                rows.forEach(row => row.remove());

                activeCoupon = '';

                if (couponApplied) couponApplied.hidden = true;
                if (couponInput) couponInput.value = '';

                renderCart();

                window.showToast?.(
                    'Đã xóa toàn bộ giỏ hàng.',
                    'success'
                );
            });

        // Prevent checkout when the cart is empty.
        document.getElementById('checkout-button')
            ?.addEventListener('click', function (event) {
                if (getCartRows().length === 0) {
                    event.preventDefault();

                    window.showToast?.(
                        'Giỏ hàng đang trống.',
                        'danger'
                    );
                }
            });

        // Initial calculation.
        renderCart();
    }

    const passwordForm = document.getElementById('profile-password-form');

    const page = document.querySelector('.et-notification-page');

    if (!page) return;

    const tabs = page.querySelectorAll('.et-notification-tab');
    const items = page.querySelectorAll('.et-notification-item');
    const markAllButton = page.querySelector('#etMarkAllRead');
    const emptyState = page.querySelector('#etNotificationEmpty');

    // Lọc thông báo theo danh mục
    function filterNotifications(category) {
        let visibleCount = 0;

        items.forEach(function (item) {
            const matches =
                category === 'all' ||
                item.dataset.category === category;

            item.hidden = !matches;

            if (matches) visibleCount++;
        });

        if (emptyState) {
            emptyState.hidden = visibleCount !== 0;
        }
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (button) {
                const active = button === tab;

                button.classList.toggle('active', active);
                button.setAttribute(
                    'aria-selected',
                    String(active)
                );
            });

            filterNotifications(tab.dataset.filter);
        });
    });

    // Đánh dấu một thông báo là đã đọc khi người dùng nhấp vào
    items.forEach(function (item) {
        item.addEventListener('click', function (event) {
            if (event.target.closest('a')) return;

            markAsRead(item);
        });
    });

    function markAsRead(item) {
        item.classList.remove('unread');

        const dot = item.querySelector(
            '.et-notification-unread-dot'
        );

        if (dot) {
            dot.remove();
        }
    }

    // Đánh dấu toàn bộ thông báo đã đọc
    if (markAllButton) {
        markAllButton.addEventListener('click', function () {
            items.forEach(markAsRead);

            if (typeof window.showToast === 'function') {
                window.showToast(
                    'Đã đánh dấu tất cả thông báo là đã đọc.',
                    'success'
                );
            }
        });
    }

    const paymentOptions = document.querySelectorAll(
        '.checkout-payment-option'
    );

    paymentOptions.forEach(function (option) {
        const radio = option.querySelector('input[type="radio"]');

        if (!radio) return;

        option.classList.toggle('selected', radio.checked);

        radio.addEventListener('change', function () {
            paymentOptions.forEach(function (item) {
                item.classList.remove('selected');
            });

            if (radio.checked) {
                option.classList.add('selected');
            }
        });

        option.addEventListener('click', function () {
            // Cập nhật trạng thái sau khi radio được trình duyệt chọn
            requestAnimationFrame(function () {
                paymentOptions.forEach(function (item) {
                    item.classList.remove('selected');
                });

                if (radio.checked) {
                    option.classList.add('selected');
                }
            });
        });
    });

    const form = document.getElementById('cancel-order-form');
    const note = document.getElementById('cancel-note');
    const charCount = document.getElementById('cancel-char-count');
    const submitButton = document.getElementById('btn-submit-cancel');

    // Character counter
    if (note && charCount) {
        note.addEventListener('input', function () {
            charCount.textContent = this.value.length;
        });
    }

    // Radio selection styling is handled by CSS.
    // Prevent duplicate form submission.
    if (form && submitButton) {
        form.addEventListener('submit', function (event) {
            const selectedReason = form.querySelector(
                'input[name="reason"]:checked'
            );

            if (!selectedReason) {
                event.preventDefault();

                if (window.showToast) {
                    window.showToast(
                        'Vui lòng chọn lý do hủy đơn hàng.',
                        'danger'
                    );
                } else {
                    alert('Vui lòng chọn lý do hủy đơn hàng.');
                }

                return;
            }

            // This is a frontend-only confirmation.
            // Replace with the actual Laravel cancellation endpoint
            // when backend processing is implemented.
            event.preventDefault();

            const confirmed = window.confirm(
                'Bạn có chắc chắn muốn gửi yêu cầu hủy đơn hàng #ORD-20261010-891 không?'
            );

            if (!confirmed) return;

            if (window.showToast) {
                window.showToast(
                    'Giao diện đã ghi nhận thao tác. Cần kết nối API để lưu yêu cầu hủy đơn.',
                    'info'
                );
            } else {
                alert('Cần kết nối API Laravel để xử lý yêu cầu hủy đơn.');
            }
        });
    }
    

});
