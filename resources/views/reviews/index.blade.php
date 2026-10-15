@extends('layouts.app')

@section('title', 'Đánh Giá & Nhận Xét Sản Phẩm - ElectroStore')

@section('content')
<div class="container-xl">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/account/profile" class="text-decoration-none">Tài khoản</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đánh giá sản phẩm</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Account Sidebar -->
        <div class="col-lg-3">
            <div class="card border rounded-4 bg-white p-3 shadow-sm mb-4">
                <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Avatar" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <div class="fw-bold text-dark">Nguyễn Văn Minh</div>
                        <span class="badge bg-warning text-dark small"><i class="bi bi-award-fill"></i> Gold Member</span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-1">
                    <a href="/account/profile" class="account-menu-link">
                        <i class="bi bi-person"></i> Thông tin cá nhân
                    </a>
                    <a href="/orders" class="account-menu-link">
                        <i class="bi bi-box-seam"></i> Quản lý đơn hàng
                    </a>
                    <a href="/reviews" class="account-menu-link active">
                        <i class="bi bi-star"></i> Đánh giá sản phẩm
                    </a>
                    <a href="/notifications" class="account-menu-link">
                        <i class="bi bi-bell"></i> Thông báo hệ thống
                    </a>
                </div>
            </div>
        </div>

        <!-- Reviews Management Section -->
        <div class="col-lg-9">
            <div class="card border rounded-4 bg-white p-4 shadow-sm mb-4">
                <div class="mb-4">
                    <h4 class="fw-bold mb-1">Đánh Giá & Nhận Xét Thiết Bị</h4>
                    <div class="small text-muted">Chia sẻ trải nghiệm sử dụng thực tế để nhận điểm thưởng thành viên Gold</div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" id="reviewTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-panel" type="button" role="tab">
                            Chờ Đánh Giá ({{ count($pendingReviews) }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="submitted-tab" data-bs-toggle="tab" data-bs-target="#submitted-panel" type="button" role="tab">
                            Đã Đánh Giá ({{ count($submittedReviews) }})
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="reviewTabsContent">
                    <!-- Tab 1: Pending Reviews -->
                    <div class="tab-pane fade show active" id="pending-panel" role="tabpanel">
                        @if(count($pendingReviews) > 0)
                        @foreach($pendingReviews as $pReview)
                        <div class="border rounded-4 p-4 mb-4 bg-light">
                            <!-- Product being reviewed -->
                            <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                                <img src="{{ $pReview['image'] }}" alt="{{ $pReview['name'] }}" class="rounded border" style="width: 70px; height: 70px; object-fit: contain; background: #fff;">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $pReview['name'] }}</h6>
                                    <div class="small text-muted">{{ $pReview['variant'] }}</div>
                                    <div class="small text-muted">Đã mua ngày: {{ $pReview['bought_at'] }} · Đơn #{{ $pReview['order_id'] }}</div>
                                </div>
                            </div>

                            <!-- Review Submission Form -->
                            <form id="submit-review-form">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Mức độ hài lòng của bạn:</label>
                                    <div class="d-flex align-items-center gap-2" id="star-rating-picker">
                                        <i class="bi bi-star-fill text-warning fs-3 rating-star-icon cursor-pointer" data-score="1"></i>
                                        <i class="bi bi-star-fill text-warning fs-3 rating-star-icon cursor-pointer" data-score="2"></i>
                                        <i class="bi bi-star-fill text-warning fs-3 rating-star-icon cursor-pointer" data-score="3"></i>
                                        <i class="bi bi-star-fill text-warning fs-3 rating-star-icon cursor-pointer" data-score="4"></i>
                                        <i class="bi bi-star-fill text-warning fs-3 rating-star-icon cursor-pointer" data-score="5"></i>
                                        <span class="ms-3 fw-bold text-dark" id="selected-star-label">Tuyệt vời, cực kỳ hài lòng (5/5)</span>
                                        <input type="hidden" name="star_score" id="selected-star-score" value="5">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Tiêu chí đánh giá:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="form-check form-check-inline border rounded-3 px-3 py-1 bg-white">
                                            <input class="form-check-input" type="checkbox" id="crit-1" checked>
                                            <label class="form-check-label small" for="crit-1">Chất lượng tuyệt vời</label>
                                        </div>
                                        <div class="form-check form-check-inline border rounded-3 px-3 py-1 bg-white">
                                            <input class="form-check-input" type="checkbox" id="crit-2" checked>
                                            <label class="form-check-label small" for="crit-2">Đúng như mô tả</label>
                                        </div>
                                        <div class="form-check form-check-inline border rounded-3 px-3 py-1 bg-white">
                                            <input class="form-check-input" type="checkbox" id="crit-3" checked>
                                            <label class="form-check-label small" for="crit-3">Đóng gói cẩn thận 3 lớp</label>
                                        </div>
                                        <div class="form-check form-check-inline border rounded-3 px-3 py-1 bg-white">
                                            <input class="form-check-input" type="checkbox" id="crit-4" checked>
                                            <label class="form-check-label small" for="crit-4">Giao hàng siêu tốc</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Nội dung nhận xét chi tiết:</label>
                                    <textarea class="form-control" name="review_content" rows="3" placeholder="Chia sẻ cảm nhận về hiệu năng, thiết kế, độ hoàn thiện hoặc thời lượng pin..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Hình ảnh / Video thực tế (tùy chọn):</label>
                                    <div class="border border-dashed rounded-3 p-3 text-center bg-white cursor-pointer" onclick="showToast('Tính năng chọn ảnh mô phỏng', 'info')">
                                        <i class="bi bi-camera fs-3 text-muted"></i>
                                        <div class="small text-muted mt-1">Bấm để tải lên ảnh sản phẩm đã mở hộp</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="anonymous-check">
                                        <label class="form-check-label small text-muted" for="anonymous-check">Đánh giá ẩn danh (che tên tài khoản)</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary-tech px-4">
                                        <i class="bi bi-send-fill me-1"></i> Gửi Đánh Giá Ngay
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-check2-circle fs-1 text-success d-block mb-2"></i>
                            Bạn không có sản phẩm nào đang chờ đánh giá.
                        </div>
                        @endif
                    </div>

                    <!-- Tab 2: Submitted Reviews -->
                    <div class="tab-pane fade" id="submitted-panel" role="tabpanel">
                        <div class="d-flex flex-column gap-3">
                            @foreach($submittedReviews as $subReview)
                            <div class="border rounded-4 p-4 bg-light bg-opacity-50">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $subReview['product_name'] }}</h6>
                                        <div class="d-flex align-items-center gap-2 small">
                                            <div class="text-warning">
                                                @for($s = 1; $s <= 5; $s++)
                                                <i class="bi bi-star{{ $s <= $subReview['rating'] ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-muted">· {{ $subReview['created_at'] }}</span>
                                            <span class="badge bg-success-subtle text-success small"><i class="bi bi-patch-check"></i> Đã xác thực mua hàng</span>
                                        </div>
                                    </div>
                                </div>

                                <p class="small text-secondary mb-3 mt-2">{{ $subReview['comment'] }}</p>

                                @if(!empty($subReview['images']))
                                <div class="d-flex gap-2 mb-3">
                                    @foreach($subReview['images'] as $img)
                                    <img src="{{ $img }}" alt="Review photo" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                                    @endforeach
                                </div>
                                @endif

                                @if(!empty($subReview['reply']))
                                <div class="p-3 bg-white rounded-3 border-start border-primary border-4 small">
                                    <div class="fw-bold text-primary mb-1"><i class="bi bi-chat-left-dots-fill"></i> Phản hồi từ ElectroStore Care:</div>
                                    <div class="text-secondary">{{ $subReview['reply'] }}</div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
