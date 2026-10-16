@extends('layouts.app')

@section('title', 'Trạng thái bảo hành | ElectroTech')

@section('content')
    <div class="warranty-page">

        {{-- Breadcrumb --}}
        <div class="warranty-breadcrumb">
            <a href="/">Trang chủ</a>
            <span>/</span>
            <a href="{{ route('warranty.index') }}">Bảo hành</a>
            <span>/</span>
            <span>Trạng thái</span>
        </div>

        {{-- Tiêu đề trang --}}
        <div class="warranty-page-heading">
            <div>
                <span class="eyebrow">THEO DÕI YÊU CẦU</span>
                <h1>Trạng thái bảo hành</h1>
                <p>Nhập mã yêu cầu hoặc số serial để xem tiến độ xử lý.</p>
            </div>

            <div class="heading-icon">
                <i class="bi bi-search"></i>
            </div>
        </div>

        {{-- Tra cứu bảo hành --}}
        <section class="w-panel status-search-panel">
            <div class="search-panel-icon">
                <i class="bi bi-search"></i>
            </div>

            <div class="search-panel-content">
                <h2>Tra cứu yêu cầu của bạn</h2>
                <p>Thông tin minh họa bên dưới chỉ phục vụ thiết kế giao diện.</p>

                <form class="w-search-form" onsubmit="event.preventDefault();">
                    <label class="w-field">
                        <span>Mã yêu cầu / Số serial</span>
                        <input type="text" placeholder="VD: WR-202610-001">
                    </label>

                    <button type="button" class="w-btn w-btn-primary">
                        <i class="bi bi-search"></i>
                        Tra cứu
                    </button>
                </form>
            </div>
        </section>

        {{-- Kết quả tra cứu --}}
        <div class="status-result-heading">
            <div>
                <h2>Kết quả tra cứu</h2>
                <p>Yêu cầu gần nhất · Dữ liệu demo</p>
            </div>

            <span class="status-pill status-processing">
                <i class="bi bi-arrow-repeat"></i>
                Đang xử lý
            </span>
        </div>

        <section class="w-panel status-detail">

            {{-- Thông tin sản phẩm --}}
            <div class="status-product-row">
                <div class="product-placeholder">
                    <i class="bi bi-phone"></i>
                </div>

                <div class="status-product-info">
                    <span class="request-code">MÃ YÊU CẦU: WR-202610-001</span>
                    <h3>Điện thoại thông minh</h3>
                    <p>Serial: ET-XXXX-XXXX · Đơn hàng: ORD-20261001-025</p>
                </div>

                <div class="status-date">
                    <small>Ngày tiếp nhận</small>
                    <b>12/10/2026</b>
                </div>
            </div>

            {{-- Tiến độ xử lý --}}
            <div class="status-progress">
                <div class="progress-line">
                    <span class="progress-line-active"></span>
                </div>

                <div class="progress-step done">
                    <span class="progress-dot">
                        <i class="bi bi-check-lg"></i>
                    </span>
                    <b>Đã tiếp nhận</b>
                    <small>12/10/2026</small>
                </div>

                <div class="progress-step done">
                    <span class="progress-dot">
                        <i class="bi bi-check-lg"></i>
                    </span>
                    <b>Kiểm tra sản phẩm</b>
                    <small>13/10/2026</small>
                </div>

                <div class="progress-step current">
                    <span class="progress-dot">
                        <i class="bi bi-tools"></i>
                    </span>
                    <b>Đang xử lý</b>
                    <small>Đang thực hiện</small>
                </div>

                <div class="progress-step">
                    <span class="progress-dot">4</span>
                    <b>Hoàn tất</b>
                    <small>Chưa cập nhật</small>
                </div>
            </div>

            {{-- Thông báo trạng thái --}}
            <div class="status-message">
                <i class="bi bi-info-circle-fill"></i>

                <div>
                    <b>Sản phẩm đang được kiểm tra và xử lý</b>
                    <p>Thông tin tiến độ sẽ được cập nhật sau khi có kết quả tiếp theo.</p>
                </div>
            </div>

            {{-- Thông tin bổ sung --}}
            <div class="status-meta-grid">
                <div>
                    <small>Hình thức tiếp nhận</small>
                    <b>Bảo hành tại trung tâm</b>
                </div>

                <div>
                    <small>Tình trạng ghi nhận</small>
                    <b>Lỗi thiết bị (demo)</b>
                </div>

                <div>
                    <small>Dự kiến hoàn tất</small>
                    <b>Đang cập nhật</b>
                </div>
            </div>

        </section>

        {{-- Các thao tác bên dưới --}}
        <div class="status-bottom-actions">
            <a class="w-btn w-btn-light" href="{{ route('warranty.history') }}">
                <i class="bi bi-clock-history"></i>
                Xem lịch sử bảo hành
            </a>

            <a class="w-btn w-btn-primary" href="{{ route('warranty.create') }}">
                <i class="bi bi-plus-lg"></i>
                Tạo yêu cầu mới
            </a>
        </div>

        <p class="form-demo-note centered">
            <i class="bi bi-info-circle"></i>
            Trạng thái, mốc thời gian và thông tin sản phẩm là dữ liệu minh họa,
            chưa kết nối hệ thống xử lý thực tế.
        </p>

    </div>
@endsection

