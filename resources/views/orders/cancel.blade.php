@extends('layouts.app')

@section('title', 'Yêu Cầu Hủy Đơn Hàng - ElectroStore')

@section('content')
<div class="container-xl cancel-order-page py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">Trang chủ</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/orders" class="text-decoration-none">Lịch sử đơn hàng</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/orders/ORD-20261010-891" class="text-decoration-none">
                    Đơn hàng #ORD-20261010-891
                </a>
            </li>
            <li class="breadcrumb-item active">Yêu cầu hủy đơn hàng</li>
        </ol>
    </nav>

    {{-- Page heading --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-2">
                <i class="bi bi-x-circle text-danger me-2"></i>
                Yêu Cầu Hủy Đơn Hàng
            </h3>
            <p class="text-muted small mb-0">
                Vui lòng cung cấp lý do để ElectroTech hỗ trợ bạn tốt hơn.
            </p>
        </div>

        <a href="/orders/ORD-20261010-891"
           class="btn btn-light border rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i>
            Quay lại đơn hàng
        </a>
    </div>

    <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- Order information --}}
            <div class="cancel-card mb-4">
                <div class="cancel-card-heading">
                    <div class="d-flex align-items-center gap-2">
                        <span class="section-icon">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <h5 class="fw-bold mb-0">Thông Tin Đơn Hàng</h5>
                    </div>

                    <span class="order-status">
                        <i class="bi bi-truck me-1"></i>
                        Đang giao hàng
                    </span>
                </div>

                <div class="order-info-grid">
                    <div>
                        <span class="info-label">Mã đơn hàng</span>
                        <strong>#ORD-20261010-891</strong>
                    </div>

                    <div>
                        <span class="info-label">Ngày đặt hàng</span>
                        <strong>08/10/2026 14:30</strong>
                    </div>

                    <div>
                        <span class="info-label">Phương thức thanh toán</span>
                        <strong>Chuyển khoản VietQR</strong>
                    </div>

                    <div>
                        <span class="info-label">Trạng thái thanh toán</span>
                        <span class="payment-status">
                            Đã thanh toán
                        </span>
                    </div>
                </div>

                <div class="order-product">
                    <img
                        src="https://placehold.co/100x100/ffdc45/111827?text=SONY"
                        alt="Tai nghe Sony WH-1000XM5"
                        class="order-product-image"
                    >

                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">
                            Tai nghe Chống ồn đỉnh cao Sony WH-1000XM5 Hi-Res Audio
                        </h6>
                        <p class="text-muted small mb-1">
                            Phân loại: Màu đen tinh tế
                        </p>
                        <span class="text-muted small">Số lượng: 1</span>
                    </div>

                    <strong class="product-price">6.990.000₫</strong>
                </div>

                <div class="order-total">
                    <span>Tổng thanh toán</span>
                    <strong>6.490.000₫</strong>
                </div>
            </div>

            {{-- Cancellation form --}}
            <div class="cancel-card">
                <div class="cancel-card-heading">
                    <div class="d-flex align-items-center gap-2">
                        <span class="section-icon section-icon-danger">
                            <i class="bi bi-clipboard2-x"></i>
                        </span>

                        <div>
                            <h5 class="fw-bold mb-1">Thông Tin Hủy Đơn</h5>
                            <p class="text-muted small mb-0">
                                Các trường có dấu <span class="text-danger">*</span> là bắt buộc.
                            </p>
                        </div>
                    </div>
                </div>

                <form id="cancel-order-form" action="#" method="POST">
                    @csrf

                    <input type="hidden" name="order_code"
                           value="ORD-20261010-891">

                    {{-- Cancellation reason --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Lý do hủy đơn hàng
                            <span class="text-danger">*</span>
                        </label>

                        <div class="cancel-reasons">

                            <label class="reason-option">
                                <input type="radio" name="reason"
                                       value="Đặt nhầm sản phẩm" required>
                                <span class="reason-radio"></span>
                                <span class="reason-content">
                                    <i class="bi bi-bag-x text-primary"></i>
                                    <span>
                                        <strong>Đặt nhầm sản phẩm</strong>
                                        <small>Tôi đã chọn sai sản phẩm hoặc số lượng.</small>
                                    </span>
                                </span>
                            </label>

                            <label class="reason-option">
                                <input type="radio" name="reason"
                                       value="Muốn thay đổi đơn hàng">
                                <span class="reason-radio"></span>
                                <span class="reason-content">
                                    <i class="bi bi-arrow-repeat text-primary"></i>
                                    <span>
                                        <strong>Muốn thay đổi đơn hàng</strong>
                                        <small>Tôi muốn đổi sản phẩm, màu sắc hoặc cấu hình.</small>
                                    </span>
                                </span>
                            </label>

                            <label class="reason-option">
                                <input type="radio" name="reason"
                                       value="Tìm được sản phẩm giá tốt hơn">
                                <span class="reason-radio"></span>
                                <span class="reason-content">
                                    <i class="bi bi-tags text-warning"></i>
                                    <span>
                                        <strong>Tìm được sản phẩm giá tốt hơn</strong>
                                        <small>Tôi muốn cân nhắc một lựa chọn khác.</small>
                                    </span>
                                </span>
                            </label>

                            <label class="reason-option">
                                <input type="radio" name="reason"
                                       value="Thời gian giao hàng quá lâu">
                                <span class="reason-radio"></span>
                                <span class="reason-content">
                                    <i class="bi bi-clock-history text-warning"></i>
                                    <span>
                                        <strong>Thời gian giao hàng quá lâu</strong>
                                        <small>Tôi không còn nhu cầu nhận hàng đúng thời gian dự kiến.</small>
                                    </span>
                                </span>
                            </label>

                            <label class="reason-option">
                                <input type="radio" name="reason"
                                       value="Lý do khác" id="reason-other">
                                <span class="reason-radio"></span>
                                <span class="reason-content">
                                    <i class="bi bi-chat-square-text text-secondary"></i>
                                    <span>
                                        <strong>Lý do khác</strong>
                                        <small>Tôi muốn cung cấp thêm thông tin.</small>
                                    </span>
                                </span>
                            </label>

                        </div>
                    </div>

                    {{-- Additional details --}}
                    <div class="mb-4">
                        <label for="cancel-note" class="form-label fw-semibold">
                            Chi tiết yêu cầu
                            <span class="text-muted fw-normal">(Không bắt buộc)</span>
                        </label>

                        <textarea
                            class="form-control cancel-textarea"
                            id="cancel-note"
                            name="note"
                            rows="4"
                            maxlength="500"
                            placeholder="Vui lòng mô tả thêm lý do bạn muốn hủy đơn hàng..."
                        ></textarea>

                        <div class="text-end small text-muted mt-1">
                            <span id="cancel-char-count">0</span>/500 ký tự
                        </div>
                    </div>

                    {{-- Refund information --}}
                    <div class="refund-notice mb-4">
                        <div class="d-flex gap-3">
                            <i class="bi bi-info-circle-fill"></i>
                            <div>
                                <strong>Thông tin hoàn tiền</strong>
                                <p class="small mb-2 mt-1">
                                    Đơn hàng đã được thanh toán qua VietQR.
                                    Nếu yêu cầu hủy được chấp thuận, việc hoàn tiền
                                    sẽ được xử lý theo chính sách của ElectroTech.
                                </p>
                                <p class="small mb-0">
                                    Thời gian hoàn tiền thực tế phụ thuộc vào ngân hàng
                                    và quy trình xác nhận giao dịch.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Confirmation checkbox --}}
                    <div class="form-check cancel-confirm mb-4">
                        <input class="form-check-input"
                               type="checkbox"
                               id="confirm-cancel"
                               name="confirm_cancel"
                               value="1"
                               required>

                        <label class="form-check-label" for="confirm-cancel">
                            Tôi xác nhận muốn hủy đơn hàng này và đã kiểm tra
                            thông tin yêu cầu.
                        </label>
                    </div>

                    <div class="cancel-actions">
                        <a href="/orders/ORD-20261010-891"
                           class="btn btn-light border rounded-3 px-4">
                            <i class="bi bi-arrow-left me-1"></i>
                            Quay lại
                        </a>

                        <button type="submit" class="btn btn-danger rounded-3 px-4"
                                id="btn-submit-cancel">
                            <i class="bi bi-x-circle me-2"></i>
                            Gửi Yêu Cầu Hủy Đơn
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- Policy card --}}
            <div class="cancel-card mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="section-icon section-icon-success">
                        <i class="bi bi-shield-check"></i>
                    </span>
                    <h6 class="fw-bold mb-0">Chính Sách Hủy Đơn</h6>
                </div>

                <div class="policy-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Đơn hàng chưa giao thành công</strong>
                        <p>Yêu cầu sẽ được kiểm tra theo trạng thái xử lý thực tế.</p>
                    </div>
                </div>

                <div class="policy-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Hoàn tiền minh bạch</strong>
                        <p>Đơn đã thanh toán sẽ được xử lý hoàn tiền nếu hủy được duyệt.</p>
                    </div>
                </div>

                <div class="policy-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Thông báo kết quả</strong>
                        <p>Bạn có thể theo dõi trạng thái yêu cầu trong lịch sử đơn hàng.</p>
                    </div>
                </div>
            </div>

            {{-- Support card --}}
            <div class="support-card mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-headset fs-4"></i>
                    <h6 class="fw-bold mb-0">Cần Hỗ Trợ?</h6>
                </div>

                <p class="small mb-3">
                    Nếu bạn cần hỗ trợ về đơn hàng hoặc hoàn tiền,
                    hãy liên hệ đội ngũ chăm sóc khách hàng.
                </p>

                <a href="tel:18006868" class="support-phone">
                    <i class="bi bi-telephone-fill me-2"></i>
                    1800.6868
                    <span class="small fw-normal">(Miễn phí)</span>
                </a>

                <div class="small mt-3">
                    <i class="bi bi-clock me-1"></i>
                    Hỗ trợ khách hàng 24/7
                </div>
            </div>

            {{-- Quick links --}}
            <div class="cancel-card">
                <h6 class="fw-bold mb-3">THAO TÁC NHANH</h6>

                <a href="/orders" class="quick-link">
                    <span><i class="bi bi-box-seam me-2"></i>Lịch sử đơn hàng</span>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="/profile" class="quick-link">
                    <span><i class="bi bi-person me-2"></i>Tài khoản cá nhân</span>
                    <i class="bi bi-chevron-right"></i>
                </a>

                <a href="/" class="quick-link">
                    <span><i class="bi bi-house me-2"></i>Tiếp tục mua sắm</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
