@extends('layouts.app')

@section('title', 'Lịch sử bảo hành')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Lịch sử bảo hành</h2>
            <p class="text-muted mb-0">
                Theo dõi các yêu cầu bảo hành của bạn
            </p>
        </div>

        <a href="{{ route('warranty.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>
            Tạo yêu cầu mới
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                    <i class="bi bi-folder2-open fs-4"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Danh sách yêu cầu</h5>
                    <p class="text-muted small mb-0">
                        Toàn bộ lịch sử yêu cầu bảo hành của bạn
                    </p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Đang xử lý</span>
                            <i class="bi bi-arrow-repeat text-warning fs-5"></i>
                        </div>
                        <h3 class="fw-bold mt-2 mb-0">02</h3>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Đã hoàn thành</span>
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        </div>
                        <h3 class="fw-bold mt-2 mb-0">05</h3>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border rounded-3 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Đã hủy</span>
                            <i class="bi bi-file-earmark-x text-danger fs-5"></i>
                        </div>
                        <h3 class="fw-bold mt-2 mb-0">01</h3>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Tìm theo mã yêu cầu hoặc tên sản phẩm..."
                        >
                    </div>
                </div>

                <div class="col-md-4">
                    <select class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending">Đang xử lý</option>
                        <option value="completed">Đã hoàn thành</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã yêu cầu</th>
                            <th>Sản phẩm</th>
                            <th>Ngày gửi</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <span class="fw-semibold">#BH001</span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3">
                                        <i class="bi bi-phone fs-4 text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">iPhone 15 Pro Max</div>
                                        <small class="text-muted">Điện thoại</small>
                                    </div>
                                </div>
                            </td>

                            <td>10/10/2026</td>

                            <td>
                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2">
                                    <i class="bi bi-arrow-repeat me-1"></i>
                                    Đang xử lý
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('warranty.status') }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Chi tiết
                                    <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="fw-semibold">#BH002</span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3">
                                        <i class="bi bi-laptop fs-4 text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">MacBook Air M3</div>
                                        <small class="text-muted">Laptop</small>
                                    </div>
                                </div>
                            </td>

                            <td>05/10/2026</td>

                            <td>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Đã hoàn thành
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('warranty.status') }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Chi tiết
                                    <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="fw-semibold">#BH003</span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3">
                                        <i class="bi bi-headphones fs-4 text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">AirPods Pro 2</div>
                                        <small class="text-muted">Tai nghe</small>
                                    </div>
                                </div>
                            </td>

                            <td>01/10/2026</td>

                            <td>
                                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill px-3 py-2">
                                    <i class="bi bi-file-earmark-x me-1"></i>
                                    Đã hủy
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('warranty.status') }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Chi tiết
                                    <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="fw-semibold">#BH004</span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3">
                                        <i class="bi bi-tablet fs-4 text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">iPad Air</div>
                                        <small class="text-muted">Máy tính bảng</small>
                                    </div>
                                </div>
                            </td>

                            <td>25/09/2026</td>

                            <td>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Đã hoàn thành
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('warranty.status') }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Chi tiết
                                    <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                <small class="text-muted">
                    Hiển thị 1–4 trong tổng số 8 yêu cầu
                </small>

                <nav aria-label="Phân trang lịch sử bảo hành">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Trang trước">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Trang sau">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="alert alert-info border-0 rounded-3 mt-4">
        <i class="bi bi-info-circle me-2"></i>
        Nếu cần hỗ trợ thêm về yêu cầu bảo hành, vui lòng liên hệ bộ phận chăm sóc khách hàng.
    </div>
</div>
@endsection
